@extends('admin.layout.main')
@section('title' , 'Quản lý dịch vụ chi tiết')
@section('content')
<div class="container">
    <div class="d-flex  justify-content-between align-item-center">
        <h3 class="my-3">Quản lý dịch vụ chi tiết</h3>
    </div>
    <h3 id="result"></h3>
    
    <div class="d-flex justify-content-between align-item-center">
        <div>
            <a href="{{route('product.create')}}" class="btn btn-primary">Thêm mới</a>
        </div>

        <form method="GET" class="col-5" action="{{route('product.index')}}" class="mb-3">
            <div class="row">
                <input type="search" id="search-name" name="q" class="form-control" placeholder="*Tìm kiếm bằng tên ...">
            </div>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr class="text-nowrap">
                <th>ID</th>
                <th>Tên</th>
                <th>Hình ảnh</th>
                <th>Nhóm dịch vụ</th>
                <th>Giá</th>
                <th>Chi tiết</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($products as $item)
            <tr>
                <td id="id">{{$item->id}}</td>
                <td><a href="{{route('product.detail.detail' , $item->id)}}">{{$item->name}}</a></td>
                <td><img width="50px" src="{{asset('upload/' .$item->image) }}" alt=""></td>
                <td>{{$item->category->name}}</td>
                <td>{{$item->price}}</td>
                <td>
                    <a href="{{route('product.detail.detail' , $item->id)}}" class="btn btn-info">Xem</a>
                </td>
                <td>
                    <select data-id="{{$item->id}}" class="form-select product-status">
                        <option @if($item->status == 1) selected @endif value="1">Active</option>
                        <option @if($item->status == 0) selected @endif value="0">Unactive</option>
                    </select>
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a href="{{route('product.edit' ,  $item->id)}}" class="dropdown-item btn btn-outline-warning" href="javascript:void(0);"><i
                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                            <a href="{{route('product.delete' ,  $item->id)}}" id="showToastPlacement"
                                onclick="return confirm('Do you want to delete this data?')"
                                class="dropdown-item btn btn-outline-danger"><i class="bx bx-trash me-1"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="my-4 float-end">
        {{ $products->appends(request()->all())->links('pagination::bootstrap-4') }}
    </div>
    @endsection
    @section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
    $(document).ready(function() {
        $('.product-status').on('change', function() {
            // alert('Nguyen Ngocj u');
            id = $(this).data('id');
            status = $(this).val();
            $.get("<?=  route('product.updateStatus')?>", {
                product_id: id,
                status: status,
            }, function($data) {
                // $('#result').html($data);
                configAlert($data);
            })
        })
    });
    </script>
    @endsection