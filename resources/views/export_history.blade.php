<div class="table-responsive">
  <table id="table" class="table table-sm table-bordered table-hover table-striped">
    <thead>
      <tr class="text-center">
        <th>Type</th>
        <th>{{ __('Product Code') }}</th>
        <th>{{ __('Product Name') }}</th>
        <th>{{ __('Amount') }}</th>
        <th>{{ __('Shelf Name') }}</th>
        <th>{{ __('User') }}</th>
        <th>{{ __('Date') }}</th>
        <th>{{ __('Ending Amount') }}</th>
        <th>{{ __('Description') }}</th>
      </tr>
    </thead>
    <tbody>
      @if(count($history) > 0)
      @foreach($history as $key => $d)
      @php
      if($d->type == 1){
      $type = "IN";
      } else {
      $type = "OUT";
      }
      @endphp
      <tr>
        <td class="text-center {{ ($type == 'IN')? 'text-success':'text-danger' }} font-weight-bold">{{ $type }}</td>
        <td class="text-center">{{ $d->product_code }}</td>
        <td>{{ $d->product_name }}</td>
        <td class="text-center">{{ $d->product_amount }}</td>
        <td class="text-center">{{ $d->shelf_name }}</td>
        <td class="text-center">{{ $d->name }}</td>
        <td class="text-center">{{ date('d/m/Y H:i:s', strtotime($d->datetime)) }}</td>
        <td class="text-center">{{ $d->ending_amount }}</td>
        <td class="text-center">{{ $d->description }}</td>
      </tr>
      @endforeach
      @else
      <tr class="text-center">
        <td colspan="9">{{ __('No data.') }}</td>
      </tr>
      @endif
    </tbody>
  </table>
</div>