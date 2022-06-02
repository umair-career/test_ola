@extends('layouts.admin')
@section('page-title')
    {{__('Create Budget Planner')}}
@endsection
@push('script-page')
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script>
        //Income Total
        $(document).on('keyup', '.income_data', function () {
            //category wise total
            var el = $(this).parent().parent();
            var inputs = $(el.find('.income_data'));

            var totalincome = 0;
            for (var i = 0; i < inputs.length; i++) {
                var price = $(inputs[i]).val();
                totalincome = parseFloat(totalincome) + parseFloat(price);
            }
            el.find('.totalIncome').html(totalincome);

            // month wise total //
            var month_income = $(this).data('month');
            var month_inputs = $(el.parent().find('.' + month_income+'_income'));
            var month_totalincome = 0;
            for (var i = 0; i < month_inputs.length; i++) {
                var month_price = $(month_inputs[i]).val();
                month_totalincome = parseFloat(month_totalincome) + parseFloat(month_price);
            }
            var month_total_income = month_income + '_total_income';
            el.parent().find('.' + month_total_income).html(month_totalincome);

            //all total //
            var total_inputs = $(el.parent().find('.totalIncome'));
            console.log(total_inputs)
            var income = 0;
            for (var i = 0; i < total_inputs.length; i++) {
                var price = $(total_inputs[i]).html();
                income = parseFloat(income) + parseFloat(price);
            }
            el.parent().find('.income').html(income);

        })

        //Expense Total
        $(document).on('keyup', '.expense_data', function () {
            //category wise total
            var el = $(this).parent().parent();
            var inputs = $(el.find('.expense_data'));

            var totalexpense = 0;
            for (var i = 0; i < inputs.length; i++) {
                var price = $(inputs[i]).val();
                totalexpense = parseFloat(totalexpense) + parseFloat(price);
            }
            el.find('.totalExpense').html(totalexpense);

           // month wise total //
            var month_expense = $(this).data('month');
            var month_inputs = $(el.parent().find('.' + month_expense+'_expense'));
            var month_totalexpense = 0;
            for (var i = 0; i < month_inputs.length; i++) {
                var month_price = $(month_inputs[i]).val();
                month_totalexpense = parseFloat(month_totalexpense) + parseFloat(month_price);
            }
            var month_total_expense = month_expense + '_total_expense';
            el.parent().find('.' + month_total_expense).html(month_totalexpense);

            //all total //
            var total_inputs = $(el.parent().find('.totalExpense'));
            console.log(total_inputs)
            var expense = 0;
            for (var i = 0; i < total_inputs.length; i++) {
                var price = $(total_inputs[i]).html();
                expense = parseFloat(expense) + parseFloat(price);
            }
            el.parent().find('.expense').html(expense);

        })

        //Hide & Show
        $(document).on('change', '.period', function() {
            var period = $(this).val();

        $('.budget_plan').removeClass('d-block');
        $('.budget_plan').addClass('d-none');
        $('#'+ period).removeClass('d-none');
        $('#'+ period).addClass('d-block');



        });


        daterange_set();
        function daterange_set(){
            $(function () {
                function cb(start, end) {
                    $('#demo11').val(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
                    $('#demo11').parent().find('.start_date').val(start.format('YYYY-MM-DD'));
                    $('#demo11').parent().find('.end_date').val(end.format('YYYY-MM-DD'));

                }

                var today = new Date();
                var endDate = new Date();
                endDate.setMonth(endDate.getMonth() + 1);
                $('#demo11').daterangepicker({
                    startDate: today,
                    endDate: endDate,
                    autoApply: true,
                    autoclose: true,
                    autoUpdateInput: false,
                    locale: {
                        format: 'MMM YYYY',
                        applyLabel: "Apply",
                        cancelLabel: "Cancel",
                        fromLabel: "From",
                        toLabel: "To"
                    }
                }, cb);
            });
        }




    </script>
@endpush

@section('content')

    <div class="card bg-none card-box">
        {{ Form::open(array('url' => 'budget','class'=>'w-100')) }}
        <div class="row">
            {{--        <input type="hidden" name="type" id="type" value="{{ csrf_token() }}">--}}

            <div class="form-group col-md-6">
                {{ Form::label('name', __('Name'),['class'=>'form-control-label']) }}
                {{ Form::text('name',null, array('class' => 'form-control','required'=>'required')) }}
            </div>

            <div class="form-group col-md-6">
                {{ Form::label('period', __('Budget Period'),['class'=>'form-control-label']) }}
                {{ Form::select('period', $periods,null, array('class' => 'form-control select2 period','required'=>'required')) }}

            </div>

{{--            <div class="form-group  col-md-6">--}}
{{--                {{ Form::label('from', __('From'),['class'=>'form-control-label']) }}--}}
{{--                {{ Form::text('from','', array('class' => 'form-control custom-daterangepicker')) }}--}}
{{--            </div>--}}

            <div class="form-group  col-md-6">
                <div class="btn-box">
                    {{ Form::label('year', __('Year'),['class'=>'text-type']) }}
                    {{ Form::select('year',$yearList,isset($_GET['year'])?$_GET['year']:'', array('class' => 'form-control select2')) }}
                </div>
            </div>
{{--            <div class="form-group  col-md-6">--}}
{{--                {{ Form::label('to', __('To'),['class'=>'form-control-label']) }}--}}
{{--                {{ Form::text('to','', array('class' => 'form-control custom-monthpicker')) }}--}}
{{--            </div>--}}


        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!---- Start Monthly Budget ------------------------------------------------------------------------>
                <div class="table-responsive budget_plan d-block"  id="monthly">
                    <table class="table table-striped mb-0" id="dataTable-manual">
                        <thead>
                        <tr>
                            <th>{{__('Category')}}</th>
                            @foreach($monthList as $month)
                                <td class="total text-dark">{{$month}}</td>
                            @endforeach
                            <th>{{__('Total :')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!------------------   Income Category ----------------------------------->
                        <tr>
                            <th colspan="14" class="text-dark"><span>{{__('Income :')}}</span></th>
                        </tr>

                        @foreach ($incomeproduct as $productService)
                            <tr>
                                <td>{{$productService->name}}</td>
                                    @foreach($monthList as $month)
                                    <td>
                                        <input type="number" class="form-control pl-1 pr-1 income_data {{$month}}_income" data-month="{{$month}}" name="income[{{$productService->id}}][{{$month}}]" value="0" id="income_data_{{$month}}">
                                    </td>
                                    @endforeach
                                <td class="totalIncome text-dark">
                                    0.00
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="text-dark">{{__('Total :')}}</td>
                            @foreach($monthList as $month)
                                <td>
                                    <span class="{{$month}}_total_income text-dark">0.00</span>
                                </td>
                            @endforeach
                            <td>
                                <span class="income text-dark">0.00</span>
                            </td>
                        </tr>

                        <!------------------   Expense Category ----------------------------------->

                        <tr>
                            <th colspan="14" class="text-dark"><span>{{__('Expense :')}}</span></th>
                        </tr>

                        @foreach ($expenseproduct as $productService)
                            <tr>
                                <td>{{$productService->name}}</td>
                                @foreach($monthList as $month)
                                    <td>
                                        <input type="number" class="form-control pl-1 pr-1 expense_data {{$month}}_expense" data-month="{{$month}}" name="expense[{{$productService->id}}][{{$month}}]" value="0" id="expense_data_{{$month}}">
                                    </td>
                                @endforeach
                                <td class="totalExpense text-dark">
                                    0.00
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td  class="text-dark">{{__('Total :')}}</span></td>
                            @foreach($monthList as $month)
                                <td>
                                    <span class="{{$month}}_total_expense text-dark">0.00</span>
                                </td>
                            @endforeach
                            <td>
                                <span class="expense text-dark">0.00</span>
                            </td>

                        </tr>

                        </tbody>

                    </table>
                    <div class="col-12 text-right">
                        <input type="submit" value="{{__('Create')}}" class="btn-create btn-xs badge-blue radius-10px">
                        <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("budget.index")}}';" class="btn-create btn-xs bg-gray radius-10px">
                    </div>
                </div>
                <!---- End Monthly Budget ----->


                <!---- Start Quarterly Budget ----------------------------------------------------------------------->
                <div class="table-responsive budget_plan d-none" id="quarterly">
                    <table class="table table-striped mb-0" id="dataTable-manual">
                        <thead>
                        <tr>
                            <th>{{__('Category')}}</th>
                            @foreach($quarterly_monthlist as $month)
                                <td class="total text-dark">{{$month}}</td>
                            @endforeach
                            <th>{{__('Total :')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!------------------   Income Category ----------------------------------->
                        <tr>
                            <th colspan="14" class="text-dark"><span>{{__('Income :')}}</span></th>
                        </tr>

                        @foreach ($incomeproduct as $productService)
                            <tr>
                                <td>{{$productService->name}}</td>
                                @foreach($quarterly_monthlist as $month)
                                    <td>
                                        <input type="number" class="form-control income_data {{$month}}_income" data-month="{{$month}}"
                                               name="income[{{$productService->id}}][{{$month}}]" value="0" id="income_data_{{$month}}">
                                    </td>
                                @endforeach
                                <td class="text-right totalIncome  text-dark">
                                    0.00
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="text-dark">{{__('Total :')}}</td>
                            @foreach($quarterly_monthlist as $month)
                                <td>
                                    <span class="{{$month}}_total_income  text-dark">0.00</span>
                                </td>
                            @endforeach
                            <td class="text-right">
                                <span class="income  text-dark">0.00</span>
                            </td>
                        </tr>



                        <!------------------   Expense Category ----------------------------------->

                        <tr>
                            <th colspan="14" class="text-dark"><span>{{__('Expense :')}}</span></th>
                        </tr>

                        @foreach ($expenseproduct as $productService)
                            <tr>
                                <td>{{$productService->name}}</td>
                                @foreach($quarterly_monthlist as $month)
                                    <td>
                                        <input type="number" class="form-control expense_data {{$month}}_expense" data-month="{{$month}}" name="expense[{{$productService->id}}][{{$month}}]" value="0" id="expense_data_{{$month}}">
                                    </td>
                                @endforeach
                                <td class="text-right totalExpense  text-dark">
                                    0.00
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td  class="text-dark">{{__('Total :')}}</span></td>
                            @foreach($quarterly_monthlist as $month)
                                <td>
                                    <span class="{{$month}}_total_expense  text-dark">0.00</span>
                                </td>
                            @endforeach
                            <td class="text-right">
                                <span class="expense  text-dark">0.00</span>
                            </td>

                        </tr>

                        </tbody>

                    </table>
                    <div class="col-12 text-right">
                        <input type="submit" value="{{__('Create')}}" class="btn-create btn-xs badge-blue radius-10px">
                        <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("budget.index")}}';" class="btn-create btn-xs bg-gray radius-10px">
                    </div>
                </div>
                <!---- End Quarterly Budget ----->


                <!---Start Half-Yearly Budget --------------------------------------------------------------------->
                <div class="table-responsive budget_plan d-none" id="half-yearly">
                    <table class="table table-striped mb-0" id="dataTable-manual">
                        <thead>
                        <tr>
                            <th>{{__('Category')}}</th>
                            @foreach($half_yearly_monthlist as $month)
                                <td class="total text-dark">{{$month}}</td>
                            @endforeach
                            <th>{{__('Total :')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!------------------   Income Category ----------------------------------->
                        <tr>
                            <th colspan="14" class="text-dark"><span>{{__('Income :')}}</span></th>
                        </tr>

                        @foreach ($incomeproduct as $productService)
                            <tr>
                                <td>{{$productService->name}}</td>
                                @foreach($half_yearly_monthlist as $month)
                                    <td>
                                        <input type="number" class="form-control income_data {{$month}}_income" data-month="{{$month}}" name="income[{{$productService->id}}][{{$month}}]" value="0" id="income_data_{{$month}}">
                                    </td>
                                @endforeach
                                <td class="text-right totalIncome  text-dark">
                                    0.00
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="text-dark">{{__('Total :')}}</td>
                            @foreach($half_yearly_monthlist as $month)
                                <td>
                                    <span class="{{$month}}_total_income  text-dark">0.00</span>
                                </td>
                            @endforeach
                            <td class="text-right">
                                <span class="income text-dark">0.00</span>
                            </td>
                        </tr>

                        <!------------------   Expense Category ----------------------------------->

                        <tr>
                            <th colspan="14" class="text-dark"><span>{{__('Expense :')}}</span></th>
                        </tr>

                        @foreach ($expenseproduct as $productService)
                            <tr>
                                <td>{{$productService->name}}</td>
                                @foreach($half_yearly_monthlist as $month)
                                    <td>
                                        <input type="number" class="form-control expense_data {{$month}}_expense" data-month="{{$month}}" name="expense[{{$productService->id}}][{{$month}}]" value="0" id="expense_data_{{$month}}">
                                    </td>
                                @endforeach
                                <td class="text-right totalExpense text-dark">
                                    0.00
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td  class="text-dark">{{__('Total :')}}</span></td>
                            @foreach($half_yearly_monthlist as $month)
                                <td>
                                    <span class="{{$month}}_total_expense text-dark">0.00</span>
                                </td>
                            @endforeach
                            <td class="text-right">
                                <span class="expense text-dark">0.00</span>
                            </td>

                        </tr>

                        </tbody>

                    </table>
                    <div class="col-12 text-right">
                        <input type="submit" value="{{__('Create')}}" class="btn-create btn-xs badge-blue radius-10px">
                        <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("budget.index")}}';" class="btn-create btn-xs bg-gray radius-10px">
                    </div>
                </div>
                <!---End Half-Yearly Budget ----->

                <!---Start Yearly Budget --------------------------------------------------------------------------------->
                <div class="table-responsive budget_plan d-none" id="yearly">
                    <table class="table table-striped mb-0" id="dataTable-manual">
                        <thead>
                        <tr>
                            <th>{{__('Category')}}</th>
                            @foreach($yearly_monthlist as $month)
                                <td class="total text-dark">{{$month}}</td>
                            @endforeach
                            <th>{{__('Total :')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!------------------   Income Category ----------------------------------->
                        <tr>
                            <th colspan="14" class="text-dark"><span>{{__('Income :')}}</span></th>
                        </tr>

                        @foreach ($incomeproduct as $productService)
                            <tr>
                                <td>{{$productService->name}}</td>

                                @foreach($yearly_monthlist as $month)

                                    <td>
                                        <input type="number" class="form-control income_data {{$month}}_income" data-month="{{$month}}" name="income[{{$productService->id}}][{{$month}}]" value="{{!empty($budget['income_data'][$productService->id][$month])?$budget['income_data'][$productService->id][$month]:0}}" id="income_data_{{$month}}">
                                    </td>
                                @endforeach
                                <td class="text-right totalIncome text-dark">
                                    0.00
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td class="text-dark">{{__('Total :')}}</td>
                            @foreach($yearly_monthlist as $month)
                                <td>
                                    <span class="{{$month}}_total_income text-dark">0.00</span>
                                </td>
                            @endforeach
                            <td class="text-right">
                                <span class="income text-dark">0.00</span>
                            </td>
                        </tr>

                        <!------------------   Expense Category ----------------------------------->

                        <tr>
                            <th colspan="14" class="text-dark"><span>{{__('Expense :')}}</span></th>
                        </tr>

                        @foreach ($expenseproduct as $productService)
                            <tr>
                                <td>{{$productService->name}}</td>
                                @foreach($yearly_monthlist as $month)
                                    <td>
                                        <input type="number" class="form-control expense_data {{$month}}_expense" data-month="{{$month}}" name="expense[{{$productService->id}}][{{$month}}]" value="{{!empty($budget['expense_data'][$productService->id][$month])?$budget['expense_data'][$productService->id][$month]:0}}" id="expense_data_{{$month}}">
                                    </td>
                                @endforeach
                                <td class="text-right totalExpense text-dark">
                                    0.00
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td  class="text-dark">{{__('Total :')}}</span></td>
                            @foreach($yearly_monthlist as $month)
                                <td>
                                    <span class="{{$month}}_total_expense text-dark">0.00</span>
                                </td>
                            @endforeach
                            <td class="text-right">
                                <span class="expense text-dark">0.00</span>
                            </td>

                        </tr>

                        </tbody>

                    </table>
                    <div class="col-12 text-right">
                        <input type="submit" value="{{__('Update')}}" class="btn-create btn-xs badge-blue radius-10px">
                        <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("budget.index")}}';" class="btn-create btn-xs bg-gray radius-10px">
                    </div>
                </div>
                <!---End Yearly Budget ----->



            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection
