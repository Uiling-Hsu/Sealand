<table class="table" style="width: 100%">
    <thead>
        <tr style="border-top: solid 1px #ccc;">
            <th scope="col" style="text-align: left;font-size: 16px;">品牌</th>
            <th scope="col" style="font-size: 16px;">車型</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subscriber->subcars as $subcar)
            <tr>
                <td>
                    &nbsp;&nbsp;{{$subcar->brandcat?$subcar->brandcat->title:''}}
                </td>
                <td style="text-align: center;">
                    {{$subcar->brandin?$subcar->brandin->title:''}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>