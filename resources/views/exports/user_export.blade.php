<table class="table table-striped table-bordered" border="1">
    <thead>
        <tr>
            <th>承租人資訊</th>
            <th>承租人姓名</th>
            <th>承租人ID</th>
            <th>駕照管轄編號</th>
            <th>承租人出生年月日</th>
            <th>承租人市話</th>
            <th>承租人手機</th>
            <th>公司名稱</th>
            <th>公司統一編號</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #dee2e6;"></td>
            <td style="border: 1px solid #dee2e6;">{{$user->name}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->idno}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->driver_no}}</td>
            <td style="border: 1px solid #dee2e6;">{{str_replace('-','/',$user->birthday)}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->telephone}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->phone}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->company_name}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->company_no}}</td>
        </tr>
    </tbody>
</table>
