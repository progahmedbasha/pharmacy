@extends('admin.layouts.header')

@section('content')



    <div class="breadcome-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <!--<li><a href="#">Home</a> <span class="bread-slash">/</span>
                                    </li>-->
                                    <li><span class="bread-blod">{{ __('accounttree.account_tree') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" >

        <div class="row" >



            <div class="col-md-12">
                <div class="modal-body">
                    <form action="{{route('update_account')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{ __('accounttree.name_arabic') }}</label>
                            <input type="text" class="form-control" name="name_ar" required value="{{$account->name_ar}}">

                            @error('name_ar')
                            {{$message}}
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('accounttree.name_english') }}</label>
                            <input type="text" class="form-control" name="name_en" required value="{{$account->name_en}}">
                            @error('name_en')
                            {{$message}}
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="pwd">دائن / مدين</label><br>
                            <input type="radio" {{$account->balance_type == 0 ? 'checked':''}}  name="credit_debit" value="0"  checked>&nbsp;&nbsp;&nbsp;دائن&nbsp;&nbsp;
                            <input type="radio" {{$account->balance_type == 1 ? 'checked':''}} name="credit_debit" value="1" >&nbsp;&nbsp;&nbsp;مدين

                            @error('credit_debit')
                            {{$message}}
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="pwd">{{ __('accounttree.final_account') }}</label>
                            <select class="form-control" name="final_acc">
                                @foreach($final_accounts as $value)
                                    <option {{$account->final_account_id == $value->id?'selected':''}} value="{{$value->id}}">{{$value->final_account}}</option>
                                @endforeach
                            </select>
                            @error('final_acc')
                            {{$message}}
                            @enderror
                        </div>

                        <input type="hidden" name="account_id" value="{{$account->id}}" />

                        <button type="submit" class="btn btn-primary">تعديل</button>
                    </form>
                </div>


            </div><!--col9  -->



        </div><!--row  -->

    </div><!--container  -->




@endsection

