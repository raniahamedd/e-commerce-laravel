 @props([
   'label' => false ,
   'name' ,
   'value' => ''  ,
   'type' => 'text', 
  ])
  
 @if( $label ) 
 <lable for=""> {{ $label }} </lable>
 @endif
 
 <input 
    type="{{ $type }}"
    name="{{ $name }}" 
    value ="{{ old($name , $value ) }}"
    {{ $attributes->class([
         'form-control', 
        'is-invalid' => $errors->has($name)
    ]) }}
  /> 
    @error( $name )
    <div class="invalid-feedback">
    {{ '** '. $message }}  
    </div>  
    @enderror