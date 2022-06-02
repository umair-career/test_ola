@extends('layouts.admin')
@section('page-title')
    {{__('Product Stock')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Product Name')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Type')}}</th>
                                <th>{{__('Description')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td class="font-style">{{$stock->created_at->format('d M Y')}}</td>
                                        <td>{{ !empty($stock->product) ? $stock->product->name : '' }}
                                        <td class="font-style">{{ $stock->quantity }}</td>
                                        <td class="font-style">{{ ucfirst($stock->type) }}</td>
                                        <td class="font-style">{{$stock->description}}</td>

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

