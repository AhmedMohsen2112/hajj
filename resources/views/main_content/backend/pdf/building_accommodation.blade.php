

<htmlpagefooter name="page-footer">
    <p style="text-align: center;">{PAGENO}</p>
</htmlpagefooter>
<style>
    @page {
        header: page-header;
        footer: page-footer;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }
    tr:nth-child(even){background-color: #f2f2f2}

    th {
        background-color: #4CAF50;
        color: white;
    }

</style>
<!--<style>
    .header,
.footer {
    width: 100%;
    text-align: center;
    position: fixed;
}
.header {
    top: 0px;
}
.footer {
    bottom: 0px;
}
.pagenum:before {
    content: counter(page);
}
</style>-->

<div class="row">
    @if($pilgrims->count()>0)
    <div class="col-sm-12">
        <table class = "table table-responsive table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>{{_lang('app.pilgrim')}}</th>
                    <th>{{_lang('app.ssn')}}</th>
                    <th>{{_lang('app.code')}}</th>
                    <th>{{_lang('app.reservation_no')}}</th>
                    <th>{{_lang('app.building')}}</th>
                    <th>{{_lang('app.floor')}}</th>
                    <th>{{_lang('app.room')}}</th>

                </tr>
            </thead>
            <tbody>
                @foreach($pilgrims as $one)
                <tr>
                    <td>{{$one->name}}</td>
                    <td>{{$one->ssn}}</td>
                    <td>{{$one->code}}</td>
                    <td>{{$one->reservation_no}}</td>
                    <td>{{$one->building_number}}</td>
                    <td>{{$one->floor_number}}</td>
                    <td>{{$one->room_number}}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    <div class="text-center">

    </div>
    @else
    <p class="text-center">{{_lang('app.no_results')}}</p>
    @endif


</div>