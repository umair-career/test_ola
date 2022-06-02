@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Company') }}
@endsection


@section('content')
    <div class="d-flex justify-content-end">
        <button class="btn btn-outline-primary mb-2 py-1 px-3" style="margin-top:-25px;" data-toggle="modal" data-target="#component-modal">
            {{__('Add')}}
        </button>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr role="row">
                                <th>{{ __('#') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($company as $row)
                                <tr class="font-style">
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $row->name }}</td>
                                    <td class="Action">
                                        <a href="javascript:void(0)" class="edit-icon"
                                           data-url="{{ route('company-edit', $row->id) }}"
                                           data-ajax-popup="true" data-title="{{ __('Update Company Name') }}"
                                           data-toggle="tooltip" data-original-title="{{ __('Update Company Name') }}">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                       {{--<a href="{{ route('company-delete', $row->id) }}" class="delete-icon">--}}
                                        <!--    <i class="fa fa-trash"></i>-->
                                        <!--</a>-->
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