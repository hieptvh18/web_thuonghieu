@extends('admin.layout.main')
@section('title', 'Dịch vụ')
@section('content')
    <div class="container">
        <a href="{{ route('product.index') }}" class="btn btn-primary mt-3"><-- Quay lại trang danh sách</a>
                @if (!isset($prodDetail))
                    <h3 class="mt-3">Thêm mới dịch vụ</h3>
                    <form class="form" method="POST" action="{{ route('product.store') }}" enctype=multipart/form-data>
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tên dịch vụ</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Name"
                                        name="name" aria-describedby="emailHelp">
                                    @if ($errors->has('name'))
                                        <span style="color: red;text-align:left">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Ảnh</label>
                                    <br>
                                    <input type="file" name="image" accept="image/*" onchange="loadFile(event)">
                                    <div class="mt-2">
                                        <img style="width:200px;height:200px;" id="output"
                                            src="https://static.vecteezy.com/system/resources/previews/004/968/608/original/upload-or-add-a-file-concept-illustration-flat-design-eps10-simple-and-modern-graphic-element-for-landing-page-empty-state-ui-infographic-button-icon-vector.jpg"
                                            alt="">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="mt-3 form-label">Giá gốc</label>
                                    <input type="text" name="price" class="form-control" placeholder="Price">
                                    @if ($errors->has('price'))
                                        <span style="color: red;text-align:left">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                {{-- <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" placeholder="Quantity">
                </div> --}}
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Trạng thái</label>
                                    <select class="form-select" name="status" aria-label="Default select example">
                                        <option value="0">Unactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Lượt xem</label>
                                    <input type="number" name="quantity_view" class="form-control"
                                        placeholder="Number view">
                                </div>


                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Danh mục dịch vụ</label>
                                    <select class="form-select" name="cate_id" aria-label="Default select example">
                                        @foreach ($cates as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Giá sau khi giảm</label>
                                    <input type="text" name="price_sale" class="form-control" placeholder="Price Sale">
                                    @if ($errors->has('price_sale'))
                                        <span style="color: red;text-align:left">{{ $errors->first('price_sale') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Mô tả</label>
                            <textarea id="summernote" name="description"></textarea>
                            @if ($errors->has('description'))
                                <span style="color: red;text-align:left">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Mô tả ngắn</label>
                            <textarea id="summernote2" name="intro_service"></textarea>
                        </div>
                        <br>
                        <button type="submit" class="my-2 float-end btn btn-primary">Submit</button>

                    </form>
                @else
                    <h3 class="mt-3">Chỉnh sửa dịch vụ</h3>
                    <form class="form" method="POST" action="{{ route('product.update', ['id' => $prodDetail->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tên</label>
                                    <input type="text" value="{{ $prodDetail->name }}" class="form-control"
                                        id="exampleInputEmail1" placeholder="Name" name="name"
                                        aria-describedby="emailHelp">
                                    @if ($errors->has('name'))
                                        <span style="color: red;text-align:left">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Hình ảnh</label>
                                    <br>
                                    {{-- <input type="file" name="image"> --}}
                                    <input type="file" name="image" accept="image/*" onchange="loadFile(event)">
                                    <input type="hidden" name="image_old" value="{{ $prodDetail->image }}">
                                    <br>
                                    @if ($prodDetail->image)
                                        <img src="{{ asset('upload/' . $prodDetail->image) }}" width="300px"
                                            class="mt-3" alt="image">
                                    @else
                                        <div class="mt-2">
                                            <img style="width:200px;height:200px;" id="output"
                                                src="https://static.vecteezy.com/system/resources/previews/004/968/608/original/upload-or-add-a-file-concept-illustration-flat-design-eps10-simple-and-modern-graphic-element-for-landing-page-empty-state-ui-infographic-button-icon-vector.jpg"
                                                alt="">
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="mt-3 form-label">Giá</label>
                                    <input type="text" value="{{ $prodDetail->price }}" name="price"
                                        class="form-control" placeholder="Price">
                                    @if ($errors->has('price'))
                                        <span style="color: red;text-align:left">{{ $errors->first('price') }}</span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="mb-3" style="display: none">
                                    <label for="exampleInputPassword1" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" value="1000" class="form-control"
                                        placeholder="Quantity">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Trạng thái</label>
                                    <select class="form-select" name="status" aria-label="Default select example">
                                        <option {{ $prodDetail->status == '0' ? 'selected' : '' }} value="0">Ẩn
                                        </option>
                                        <option {{ $prodDetail->status == '1' ? 'selected' : '' }} value="1">Hoạt
                                            động</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span style="color: red;text-align:left">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Lượt xem</label>
                                    <input type="number" value="{{ $prodDetail->quantity_view }}" name="quantity_view"
                                        class="form-control" placeholder="Number view">
                                    @if ($errors->has('quantity_view'))
                                        <span
                                            style="color: red;text-align:left">{{ $errors->first('quantity_view') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Danh mục dịch vụ</label>
                                    <select class="form-select" name="cate_id" aria-label="Default select example">
                                        @foreach ($cates as $item)
                                            <option {{ $prodDetail->cate_id == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('cate_id'))
                                        <span style="color: red;text-align:left">{{ $errors->first('cate_id') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Giá sau khi giảm</label>
                                    <input type="text" value="{{ $prodDetail->price_sale ?? 0 }}" name="price_sale"
                                        class="form-control" placeholder="Price Sale">
                                        @if ($errors->has('price_sale'))
                                        <span style="color: red;text-align:left">{{ $errors->first('price_sale') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Mô tả</label>
                            <textarea id="summernote" name="description">{{ $prodDetail->description }}</textarea>
                            @if ($errors->has('description'))
                            <span style="color: red;text-align:left">{{ $errors->first('description') }}</span>
                        @endif
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Mô tả ngắn</label>
                            <textarea id="summernote2" name="intro_service">{{ $prodDetail->intro_service }}</textarea>
                            @if ($errors->has('intro_service'))
                            <span style="color: red;text-align:left">{{ $errors->first('intro_service') }}</span>
                        @endif
                        </div>
                        <br>
                        <button type="submit" class="my-2 float-end btn btn-primary">Update</button>
                    </form>
                @endif
    </div>
@endsection
@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/adminProduct/adminProduct.js') }}"></script>
    <script>
        if (session() - > forget('save-success-product')) {
            checkConfirm();
        }
    </script>
@endsection
