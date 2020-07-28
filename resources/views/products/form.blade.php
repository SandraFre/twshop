@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @isset($item->id)
                            Edit
                        @else
                            New
                        @endisset
                        Product
                    </div>

                    <form action="{{ route('products.'. (isset($item->id) ? 'update' : 'store'), isset($item->id) ? ['product' => $item->id] : []) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @isset($item->id)
                            @method('put')
                        @endisset
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control @error('title') is-invalid @enderror" id="title" type="text"
                                       name="title" value="{{ old('title', $item->title ?? null) }}">
                                @error('title')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input class="form-control @error('slug') is-invalid @enderror" id="slug" type="text"
                                       name="slug" value="{{ old('slug', $item->slug ?? null) }}">
                                @error('slug')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="code">Code</label>
                                <input class="form-control @error('code') is-invalid @enderror" id="code" type="text"
                                       name="code" value="{{ old('code', $item->code ?? null) }}">
                                @error('code')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input class="form-control-file" id="image" name="image" value="" type="file" >
                                @error('image')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input class="form-control @error('price') is-invalid @enderror" id="price" type="text"
                                       name="price" value="{{ old('price', $item->price ?? 0.01) }}" min="0.01">
                                @error('price')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sale_price">Sale price</label>
                                <input class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" type="text"
                                       name="sale_price" value="{{ old('sale_price', $item->sale_price ?? null) }}">
                                @error('sale_price')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="size">Size</label>
                                <input class="form-control @error('slug') is-invalid @enderror" id="size" type="text"
                                       name="size" value="{{ old('size', $item->size ?? null) }}">
                                @error('size')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description">{{ old('description', $item->description ?? null) }}</textarea>
                                @error('description')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="categories">Categories</label>
                                @foreach($categories as $id => $title)
                                    <input type="checkbox" id="categories" name="categories[]"
                                           value="{{ $id }}"
                                           @if(in_array($id, old('categories', $categoryIds ?? []))) checked @endif
                                    > {{ $title }}
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                       type="text"
                                       name="quantity" value="{{ old('quantity', $item->quantity ?? 0) }}">
                                @error('quantity')
                                <em class="alert-danger">{{ $message }}</em>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer">
                            <input type="submit" class="btn btn-sm btn-outline-success" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
