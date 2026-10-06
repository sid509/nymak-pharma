import Link from '@tiptap/extension-link';
import { EditorContent, useEditor, useEditorState } from '@tiptap/react';
import StarterKit from '@tiptap/starter-kit';
import {
    Bold, Heading2, Heading3, Italic, Link2, List, ListOrdered, Minus, Quote, Redo2,
    RemoveFormatting, Strikethrough, Underline as UnderlineIcon, Undo2, Unlink2,
} from 'lucide-react';
import { useEffect } from 'react';

/**
 * WYSIWYG editor (TipTap) for admin HTML fields. Emits HTML on every change;
 * the server sanitises it again before storing (App\Support\Html), so the
 * toolbar is a convenience, not the security boundary.
 */
export default function RichText({ id, value = '', onChange, placeholder = 'Write here…' }) {
    const editor = useEditor({
        extensions: [
            StarterKit.configure({
                heading: { levels: [2, 3] },
                code: false,
                codeBlock: false,
                link: false,
            }),
            Link.configure({
                openOnClick: false,
                autolink: true,
                defaultProtocol: 'https',
                HTMLAttributes: { rel: 'noopener noreferrer', target: '_blank' },
            }),
        ],
        content: value || '',
        immediatelyRender: false,
        editorProps: {
            attributes: {
                id,
                class: 'richtext-body prose-nymak min-h-[14rem] px-4 py-3 text-sm focus:outline-none',
                'data-placeholder': placeholder,
            },
        },
        onUpdate: ({ editor: e }) => onChange(e.isEmpty ? '' : e.getHTML()),
    });

    // Keep the editor in sync if the parent resets the value (e.g. form reset).
    useEffect(() => {
        if (editor && (value || '') !== editor.getHTML() && !(editor.isEmpty && !value)) {
            editor.commands.setContent(value || '', { emitUpdate: false });
        }
    }, [value, editor]);

    // TipTap v3 doesn't re-render on every transaction; subscribe to just the
    // state the toolbar paints so active buttons track the cursor.
    // Note: the snapshot only populates after the first transaction, so fall
    // back to an inactive toolbar rather than blocking the editor mount.
    const st = useEditorState({
        editor,
        selector: ({ editor: e }) => (e ? {
            bold: e.isActive('bold'), italic: e.isActive('italic'), underline: e.isActive('underline'), strike: e.isActive('strike'),
            h2: e.isActive('heading', { level: 2 }), h3: e.isActive('heading', { level: 3 }),
            bullet: e.isActive('bulletList'), ordered: e.isActive('orderedList'), quote: e.isActive('blockquote'),
            link: e.isActive('link'), canUndo: e.can().undo(), canRedo: e.can().redo(),
        } : null),
    }) ?? {};

    if (!editor) {
        return <div className="richtext min-h-[17rem] animate-pulse rounded-lg border border-ink-200 bg-ink-50" aria-hidden />;
    }

    const setLink = () => {
        const previous = editor.getAttributes('link').href || '';
        const url = window.prompt('Link URL', previous);
        if (url === null) return;
        if (url.trim() === '') {
            editor.chain().focus().extendMarkRange('link').unsetLink().run();
            return;
        }
        editor.chain().focus().extendMarkRange('link').setLink({ href: url.trim() }).run();
    };

    const Btn = ({ onClick, active = false, disabled = false, label, children }) => (
        <button type="button" onClick={onClick} disabled={disabled} aria-label={label} title={label}
                aria-pressed={active} onMouseDown={(e) => e.preventDefault()} // keep selection + focus in the editor
                className={`rounded-md p-1.5 text-ink-600 transition-colors hover:bg-ink-100 hover:text-ink-900 disabled:opacity-40 disabled:hover:bg-transparent ${
                    active ? 'bg-brand-50 text-brand-800' : ''}`}>
            {children}
        </button>
    );
    const Sep = () => <span className="mx-1 h-5 w-px bg-ink-200" aria-hidden />;

    return (
        <div className="richtext overflow-hidden rounded-lg border border-ink-200 bg-white transition-colors focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-100">
            <div role="toolbar" aria-label="Formatting" className="flex flex-wrap items-center gap-0.5 border-b border-ink-100 bg-ink-50/60 px-2 py-1.5">
                <Btn label="Bold" active={st.bold} onClick={() => editor.chain().focus().toggleBold().run()}><Bold size={15} /></Btn>
                <Btn label="Italic" active={st.italic} onClick={() => editor.chain().focus().toggleItalic().run()}><Italic size={15} /></Btn>
                <Btn label="Underline" active={st.underline} onClick={() => editor.chain().focus().toggleUnderline().run()}><UnderlineIcon size={15} /></Btn>
                <Btn label="Strikethrough" active={st.strike} onClick={() => editor.chain().focus().toggleStrike().run()}><Strikethrough size={15} /></Btn>
                <Sep />
                <Btn label="Heading" active={st.h2} onClick={() => editor.chain().focus().toggleHeading({ level: 2 }).run()}><Heading2 size={15} /></Btn>
                <Btn label="Subheading" active={st.h3} onClick={() => editor.chain().focus().toggleHeading({ level: 3 }).run()}><Heading3 size={15} /></Btn>
                <Sep />
                <Btn label="Bullet list" active={st.bullet} onClick={() => editor.chain().focus().toggleBulletList().run()}><List size={15} /></Btn>
                <Btn label="Numbered list" active={st.ordered} onClick={() => editor.chain().focus().toggleOrderedList().run()}><ListOrdered size={15} /></Btn>
                <Btn label="Quote" active={st.quote} onClick={() => editor.chain().focus().toggleBlockquote().run()}><Quote size={15} /></Btn>
                <Btn label="Divider" onClick={() => editor.chain().focus().setHorizontalRule().run()}><Minus size={15} /></Btn>
                <Sep />
                <Btn label="Add link" active={st.link} onClick={setLink}><Link2 size={15} /></Btn>
                <Btn label="Remove link" disabled={!st.link} onClick={() => editor.chain().focus().unsetLink().run()}><Unlink2 size={15} /></Btn>
                <Btn label="Clear formatting" onClick={() => editor.chain().focus().clearNodes().unsetAllMarks().run()}><RemoveFormatting size={15} /></Btn>
                <Sep />
                <Btn label="Undo" disabled={!st.canUndo} onClick={() => editor.chain().focus().undo().run()}><Undo2 size={15} /></Btn>
                <Btn label="Redo" disabled={!st.canRedo} onClick={() => editor.chain().focus().redo().run()}><Redo2 size={15} /></Btn>
            </div>
            <EditorContent editor={editor} />
        </div>
    );
}
