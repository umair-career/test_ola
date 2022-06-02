@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Product Stock') }}
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr role="row">
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Sku') }}</th>
                                <th>{{ __('Current Quantity') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($productServices as $productService)
                                <tr class="font-style">
                                    <td>{{ $productService->name }}</td>
                                    <td>{{ $productService->sku }}</td>
                                    <td>{{ $productService->quantity }}</td>

                                        <td class="Action">
                                                <a href="#" class="edit-icon"
                                                   data-url="{{ route('productstock.edit', $productService->id) }}"
                                                   data-ajax-popup="true" data-title="{{ __('Update Quantity') }}"
                                                   data-toggle="tooltip" data-original-title="{{ __('Update Quantity') }}">
                                                    <i class="fa fa-plus"></i>
                                                </a>

                                        </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
