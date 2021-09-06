
<ul class="nested">
    @foreach($childs as $child)
    <li>

            <span class=" @if(count($child->children_accounts)) caret @endif account_name_{{$child->id}}">{{$child->name}}</span>
            <div class="d-flex" style="margin: 10px 0;">
                <button class="btn btn-success edit-account" data-toggle="modal" data-target="#edit_account_modal" data-account_id="{{$child->id}}"><i class="fa fa-edit"></i></button>

                <button class="btn mx-1 btn-default new_account" data-account_id="{{$child->id}}"><i class="fa fa-plus"></i></button>
                @if($child->id > 27)
                    <form method="post" class="delete_form" action="{{ route('admin.accountsTree.destroy',$child->id) }}">
                      {{ method_field('DELETE') }}
                      {{  csrf_field() }}
                      <button class="btn btn-danger delete_account"><i class="fa fa-trash"></i></button>
                    </form>


                @endif
            </div>
            @if(count($child->children_accounts))
                @include('admin.Finances.Reports.tree_level',['childs' => $child->children_accounts])
            @endif

    </li>
    @endforeach
</ul>
