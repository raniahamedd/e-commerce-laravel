
    <div class="form-group">
        <x-form.input label="Category Name" type='text' name='name' :value="$category->name"/>
    </div>


    <div class="form-group">
        <lable for=""> Category Parent </lable>
        <select name="parent_id" class="form-control form-select">
            <option value=""> Primary Category </option>
            @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id',$category->parent_id ) == $parent->id)> {{ $parent->name }}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group">
        <x-form.textarea label="Description" name="description" :value="$category->description" />
    </div>


    <div class="form-group">
        <x-form.input label="Image" type="file" name="image" class='mb-2' accept="image/*"/>
        @if( $category->image )
         <img src="{{ asset("storage/" . $category->image) }}" width='150' height='120' />
        @endif
    </div>


    <div class="form-group">
     <x-form.radio label="Status" name="status" :checked="$category->status" :options="['active' => 'Active' , 'archived' => 'Archived' ]"/>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary"> {{ $button_label ?? 'save' }}</button>
    </div>

