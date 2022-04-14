@props(['size' => 'table-sm', 'variant' => ''])

<table {{ $attributes->merge(['class' => 'w-100 table align-middle table-hover ' . ' ' . $variant . ' ' . $size]) }}>
   <thead class="text-muted">
      <tr>
         {{ $headers }}
      </tr>
   </thead>

   @isset($rows)
      <tbody>
         {{ $rows }}
      </tbody>
   @endisset

   @isset($footers)
      <tfoot class="text-muted">
         <tr>
            {{ $footers }}
         </tr>
      </tfoot>
   @endisset
</table>
