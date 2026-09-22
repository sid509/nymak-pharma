# {{ $c['name'] }}

> {{ $c['description'] }}

## Company facts

- Legal name: {{ $c['legal_name'] }}
- Founded: {{ $c['founded'] }} by {{ $c['founder'] }}
- HQ & works: {{ $c['address']['street'] }}, {{ $c['address']['city'] }}, {{ $c['address']['region'] }}, {{ $c['address']['country'] }}
- Branch office: {{ $c['branch_address'] }}
@if(!empty($c['offices']))
- International offices: {{ collect($c['offices'])->map(fn ($o) => $o['name'])->implode(' · ') }}
@endif
- Certifications: WHO-GMP, ISO 13485:2016, Star Export House, Pharmexcil RCMC, IEC, GST
- Contact: {{ $c['phone'] }} · {{ $c['email'] }}

## Product segments

@foreach($categories as $cat)
- {{ $cat->name }}@if($cat->intro) — {{ $cat->intro }}@endif
@endforeach

## Export markets

{{ $markets->count() }}+ markets including {{ $markets->take(11)->implode(', ') }} and more.

## Important pages

- [About Us]({{ url('/about') }}): company history, leadership and credentials
- [Manufacturing]({{ url('/manufacturing') }}): WHO-GMP facility, QC/QA and regulatory capability
- [Quality & Certifications]({{ url('/quality-certifications') }}): WHO-GMP, ISO 13485, Star Export House
- [Products]({{ url('/products') }}): full product portfolio by segment
@foreach($categories as $cat)
- [{{ $cat->name }}]({{ url('/products/'.$cat->slug) }}): product catalogue
@endforeach
- [Global Presence]({{ url('/global-presence') }}): export markets and international offices
- [Blog]({{ url('/blog') }}): company and product insights
- [FAQs]({{ url('/faqs') }}): common questions about products, quality and exports
- [Contact]({{ url('/contact') }}): enquiry form, offices and contact details
