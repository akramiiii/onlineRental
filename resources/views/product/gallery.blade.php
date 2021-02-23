@extends('layouts.admin')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
@endsection
@section('content')
    @include('include.breadcrumb' , ['data' => [
        ['title' => 'مدیریت محصولات' , 'url' => url("admin/product")],
        ['title' => 'گالری تصاویر' , 'url' => url("admin/product/gallery/".$product->id)],
    ]])
    <div class="panel">
        <div class="header">
            گالری تصاویر - {{ $product->title }} 
        </div>
        <div class="panel_content">
            @include('include.alert')

            <form method="post" id="upload-file" action="{{ url('admin/product/gallery_upload/'.$product->id) }}" class="dropzone">
                @csrf
                <input style="display: none" type="file" name="file" multiple>
            </form>

            <table class="table table-bordered" id="gallery_table">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>تصویر</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; ?>
                    @foreach ($product_gallery as $gallery)
                        <tr id="{{ $gallery->id }}">
                            <td>{{ $i }}</td>
                            <td>
                                <img src="{{ url('files/gallery/' . $gallery->image_url) }}">
                            </td>
                            <td>
                                <span data-toggle="tooltip" data-placement="bottom" title="حذف تصویر" onclick="del_row('{{ url('admin/product/gallery/'.$gallery->id) }}' , '{{ Session::token() }}' , 'آیا از حذف این تصویر مطمئن هستید ؟')" class="fa fa-remove" style="cursor: pointer"></span>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
    <script>
        Dropzone.options.uploadFile={
            acceptedFiles:'.jpg,.png,.jpeg',
            addRemoveLinks:true,
            init:function(){
                this.options.dictRemoveFile='حذف';
                this.options.dictInvalidFileType='امکان آپلود این فایل وجود ندارد';
                this.on('success' , function(file,response){
                    if(response == 1){
                        file.previewElement.classList.add('dz-success');
                    }
                    else{
                        file.previewElement.classList.add('dz-error');
                        $(file.previewElement).find('.dz-error-message').text('خطا در آپلود فایل');
                    }
                });
            }
        }

        const $sortable = $('#gallery_table > tbody');
        $sortable.sortable({
            stop:function(event , ui){
                $('#loading_box').show();
                const parameters = $sortable.sortable("toArray");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ url('admin/product/change_images_status/'.$product->id) }}',
                    type: "POST",
                    data: "parameters="+parameters,
                    success: function (data) {
                        $('#loading_box').hide();
                    }
                });
            }
        });
    </script>
@endsection