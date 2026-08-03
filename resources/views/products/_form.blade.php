<div class="modal fade"
     id="productModal"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            @if(isset($editProduct))

                <form action="{{ route('products.update', $editProduct) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

            @else

                <form action="{{ route('products.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

            @endif


            <div class="modal-header">

                <h5 class="modal-title">

                    {{ isset($editProduct) ? 'Edit Product' : 'Add Product' }}

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">


                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Category

                        </label>


                        <select
                            name="category_id"
                            class="form-select">


                            <option value="">

                                Select Category

                            </option>


                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id', $editProduct->category_id ?? '') == $category->id)>

                                    {{ $category->name }}

                                </option>

                            @endforeach


                        </select>


                    </div>



                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Brand

                        </label>


                        <select
                            name="brand_id"
                            class="form-select">


                            <option value="">

                                Select Brand

                            </option>


                            @foreach($brands as $brand)

                                <option
                                    value="{{ $brand->id }}"
                                    @selected(old('brand_id', $editProduct->brand_id ?? '') == $brand->id)>

                                    {{ $brand->name }}

                                </option>

                            @endforeach


                        </select>


                    </div>


                </div>




                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Product Name

                        </label>


                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $editProduct->name ?? '') }}">


                    </div>



                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            SKU

                        </label>


                        <input
                            type="text"
                            name="sku"
                            class="form-control"
                            value="{{ old('sku', $editProduct->sku ?? '') }}">


                    </div>


                </div>





                <div class="row">


                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Price

                        </label>


                        <input
                            type="number"
                            step="0.01"
                            name="price"
                            class="form-control"
                            value="{{ old('price', $editProduct->price ?? '') }}">


                    </div>




                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Discount Price

                        </label>


                        <input
                            type="number"
                            step="0.01"
                            name="discount_price"
                            class="form-control"
                            value="{{ old('discount_price', $editProduct->discount_price ?? '') }}">


                    </div>




                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Quantity

                        </label>


                        <input
                            type="number"
                            name="quantity"
                            class="form-control"
                            value="{{ old('quantity', $editProduct->quantity ?? '') }}">


                    </div>




                    <div class="col-md-4 mb-3">

                        <label class="form-label">

                            Maximum Order Quantity

                        </label>


                        <input
                            type="number"
                            name="max_order_quantity"
                            class="form-control"
                            min="1"
                            value="{{ old('max_order_quantity', $editProduct->max_order_quantity ?? '') }}">


                    </div>


                </div>





                <div class="mb-3">

                    <label class="form-label">

                        Product Image

                    </label>


                    <input
                        type="file"
                        name="image"
                        class="form-control">



                    @if(isset($editProduct) && $editProduct->image)

                        <div class="mt-2">

                            <img
                                src="{{ asset('storage/'.$editProduct->image) }}"
                                width="100"
                                class="img-thumbnail">

                        </div>

                    @endif


                </div>





                <div class="mb-3">

                    <label class="form-label">

                        Description

                    </label>


                    <textarea
                        name="description"
                        rows="4"
                        class="form-control">{{ old('description', $editProduct->description ?? '') }}</textarea>


                </div>





                <div class="row">


                    <div class="col-md-6 mb-3">


                        <label class="form-label">

                            Featured

                        </label>


                        <select
                            name="featured"
                            class="form-select">


                            <option value="1"
                                @selected(old('featured', $editProduct->featured ?? 0) == 1)>

                                Yes

                            </option>


                            <option value="0"
                                @selected(old('featured', $editProduct->featured ?? 0) == 0)>

                                No

                            </option>


                        </select>


                    </div>





                    <div class="col-md-6 mb-3">


                        <label class="form-label">

                            Status

                        </label>


                        <select
                            name="status"
                            class="form-select">


                            <option value="1"
                                @selected(old('status', $editProduct->status ?? 1) == 1)>

                                Active

                            </option>


                            <option value="0"
                                @selected(old('status', $editProduct->status ?? 1) == 0)>

                                Inactive

                            </option>


                        </select>


                    </div>


                </div>



            </div>





            <div class="modal-footer">


                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cancel

                </button>



                <button
                    type="submit"
                    class="btn btn-primary">

                    {{ isset($editProduct) ? 'Update' : 'Save' }}

                </button>


            </div>


            </form>


        </div>

    </div>

</div>





@if(isset($editProduct))

<script>

document.addEventListener('DOMContentLoaded', function () {

    let modal = new bootstrap.Modal(
        document.getElementById('productModal')
    );

    modal.show();

});

</script>

@endif