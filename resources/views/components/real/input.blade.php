@props(['type' => 'text', 'size' => 'md', 'marginBottom' => '3'])


<div
   class="{{ in_array($type, ['checkbox', 'radio']) ? 'form-check form-switch' : 'form-floating' }} mb-{{ $marginBottom }}">
   @switch($type)
      @case('textarea')
        <textarea autocomplete="off" placeholder="_" style="height: 120px"
            {{ $attributes->merge(['class' => 'form-control form-control-' . $size]) }}>@isset($oldValue){{ $oldValue }}@endisset</textarea>
         @isset($label)
            <label>{{ $label }}</label>
         @endisset
      @break

      @case('select')
         <select autocomplete="off" {{ $attributes->merge(['class' => 'form-select form-select-' . $size]) }}
            @isset($oldValue) value="{{ $oldValue }}" @endisset>
            @isset($options)
               {{ $options }}
            @endisset
         </select>
         @isset($label)
            <label>{{ $label }}</label>
         @endisset
      @break

      @case('checkbox')
         <input type="checkbox" {{ $attributes->merge(['class' => 'form-check-input']) }}
            @isset($oldValue) checked @endisset />
         @isset($label)
            <label class="form-check-label">{{ $label }}</label>
         @endisset
      @break

      @case('radio')
         <input type="radio" {{ $attributes->merge(['class' => 'form-check-input']) }}
            @isset($oldValue) checked @endisset />
         @isset($label)
            <label class="form-check-label">{{ $label }}</label>
         @endisset
      @break

      @default
         <input autocomplete="off" {{ $attributes->merge(['class' => 'form-control form-control-' . $size]) }}
            type="{{ $type }}" placeholder="_"
            @isset($oldValue) value="{{ $oldValue }}" @endisset />
         @isset($label)
            <label>{{ $label }}</label>
         @endisset
   @endswitch

   <div class="hstack gap-3">
      @isset($formText)
         <span class="form-text text-muted">
            {{ $formText }}
         </span>
      @endisset

      @isset($formError)
         <div class="invalid-feedback">
            {{ $formError }}
         </div>
      @endisset
   </div>
</div>
