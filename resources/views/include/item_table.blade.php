<div class="dropdown">
  <button class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    گزینه ها
  </button>

  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" href="{{ url($route.'/create') }}">
        <span class="fa fa-pencil"></span>
        <span>افزودن {{ $title }} جدید</span>
    </a>
    <a class="dropdown-item" href="{{ url($route.'?trashed=true') }}">
        <span class="fa fa-trash"></span>
        <span>سطل زباله ({{ $count }})</span>
    </a>
    <a class="dropdown-item off item-form" style="cursor: pointer" id="remove_items" msg = "آیا از حذف {{ $title }} های انتخابی مطمئن هستید ؟ ">
        <span class="fa fa-remove"></span>
        <span>حذف {{ $title }} ها</span>
    </a>
    @if (isset($_GET['trashed']) && $_GET['trashed'] == 'true')
        <a class="dropdown-item off item-form" style="cursor: pointer" id="restore_items" msg = "آیا از بازیابی {{ $title }} های انتخابی مطمئن هستید ؟ ">
          <span class="fa fa-refresh"></span>
          <span>بازیابی {{ $title }} ها</span>
        </a>
    @endif
  </div>
</div>
