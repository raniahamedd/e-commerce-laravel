        <div class="form-group">
            <x-form.input label="Product Name" type='text' name='name' :value="$product->name" />
        </div>

        <div class="form-group">
            <lable for=""> Category </lable>
            <select name="category_id" class="form-control form-select">
                <option value=""> Primary Category </option>
                @foreach (App\Models\Category::all() as $category)
                <option value="{{ $category->id }}" @selected( old('category_id', $category->id ) == $category->id )> {{
                    $category->name }} </option>
                @endforeach
            </select>
        </div>


        <div class="form-group">
            <x-form.textarea label="Description" name="description" :value="$product->description" />
        </div>


        <div class="form-group">
            <x-form.input label="Image" type="file" name="image" class='mb-2' accept="image/*" />
            {{-- @if( $product->image )
            <img src="{{ asset(" storage/" . $category->image) }}" width='150' height='120' />
            @endif --}}
        </div>

        <div class="form-group">
            <x-form.input label="Price" name="price" :value="$product->price" />
        </div>
        <div class="form-group">
            <x-form.input label="Compare Price" name="compare_price" :value="$product->compare_price" />
        </div>
        <div class="form-group">
            <x-form.input label="Tags" name="tags"  :value="$tags"  />
        </div>
        <div class="form-group">
            <label for="">Status</label>
            <div>
                <x-form.radio name="status" :checked="$product->status"
                    :options="['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived']" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"> {{ $button_label ?? 'save' }}</button>
            </div>
    @push('styles')
    <link href="{{ asset('css/tagify.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
    <script src="{{ asset('js/tagify.js') }}"></script>
    <script src="{{ asset('js/tagify.polyfills.min.js') }}"></script>
    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify (inputElm);
    </script>
    @endpush
