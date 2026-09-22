<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Shared CRUD for simple content entities (FAQs, testimonials,
 * certifications, team members). Each subclass declares its model, form
 * request and field definitions — one implementation, one place to fix.
 */
abstract class CrudController extends Controller
{
    abstract protected function model(): string;

    abstract protected function request(): string;

    /** Column + field definitions sent to the generic React CRUD pages. */
    abstract protected function config(): array;

    /** Resolve the bound record from the route's resource parameter. */
    protected function record(Request $request): Model
    {
        $param = collect($request->route()->parameters())->last();

        return $param instanceof Model ? $param : $this->model()::findOrFail($param);
    }

    protected function validated(Request $request): array
    {
        /** @var \Illuminate\Foundation\Http\FormRequest $form */
        $form = app($this->request());
        $form->setContainer(app())->setRedirector(app('redirect'));
        $form->merge($request->all());
        $form->setRouteResolver($request->getRouteResolver());
        $form->validateResolved();

        return $form->validated();
    }

    public function index(Request $request): Response
    {
        $model = $this->model();
        $searchable = $this->config()['searchable'] ?? [];

        return Inertia::render('Admin/Crud/Index', [
            'module' => $this->config()['module'],
            'columns' => $this->config()['columns'],
            'rows' => $model::query()
                ->when($request->q && $searchable, fn ($q, $s) => $q->where(fn ($w) => collect($searchable)
                    ->each(fn ($col) => $w->orWhere($col, 'like', "%{$s}%"))))
                ->orderBy('sort_order')->orderBy('id')
                ->paginate(25)->withQueryString(),
            'filters' => $request->only('q'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Crud/Form', [
            'module' => $this->config()['module'],
            'fields' => $this->config()['fields'],
            'record' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->model()::create($this->validated($request));

        return $this->backToIndex('created');
    }

    public function edit(Request $request): Response
    {
        return Inertia::render('Admin/Crud/Form', [
            'module' => $this->config()['module'],
            'fields' => $this->config()['fields'],
            'record' => $this->record($request),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->record($request)->update($this->validated($request));

        return $this->backToIndex('updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->record($request)->delete();

        return $this->backToIndex('deleted');
    }

    protected function backToIndex(string $verb): RedirectResponse
    {
        return redirect()->route("admin.{$this->config()['module']['route']}.index")
            ->with('success', Str::singular($this->config()['module']['title'])." {$verb}.");
    }
}
