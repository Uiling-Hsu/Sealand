<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>會員ID</th>
        <th>姓名</th>
        <th>Email</th>
        <th>電話</th>
        <th>性別</th>
        <th>生日</th>
        <th>訂閱方案</th>
        <th>車型</th>
        <th>車號</th>
        <th>是否已付保證金</th>
        <th>是否取消</th>
        <th>身分證字號</th>
        <th>換證地點</th>
        <th>領補換類別</th>
        <th>戶籍地址</th>
        <th>駕照管轄編號</th>
        <th>緊急連絡人</th>
        <th>緊急連絡電話</th>
        <th>公司抬頭</th>
        <th>公司統編</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $key=>$user)
        @php

            $ords=\App\Model\Ord::where('user_id',$user->id)->orderBy('created_at')->get();
        @endphp
            @if($ords->count()>0)
                @foreach($ords as $ord)
                    @php
                        $cate=$ord->cate;
                    @endphp
                    <tr>
                        <td style="border: 1px solid #dee2e6;">{{$key+1}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->id}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->name}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->email}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->phone}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->gender}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->birthday}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$cate?$cate->title:''}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$ord->brandin_name}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$ord->plate_no}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$ord->is_paid==1?'是':'否'}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$ord->is_cancel==1?'是':'否'}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->idno}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->ssite?$user->ssite->title:''}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->applyreason}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->address}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->driver_no}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->emergency_contact}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->emergency_phone}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->company_name}}</td>
                        <td style="border: 1px solid #dee2e6;">{{$user->company_no}}</td>
                        {{--<td style="width: 5%;border: 1px solid #dee2e6;">{{$product->partner?$product->partner->address:''}}</td>--}}
                    </tr>
                @endforeach
            @else
                <tr>
                    <td style="border: 1px solid #dee2e6;">{{$key+1}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->id}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->name}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->email}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->phone}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->gender}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->birthday}}</td>
                    <td style="border: 1px solid #dee2e6;">&nbsp;</td>
                    <td style="border: 1px solid #dee2e6;">&nbsp;</td>
                    <td style="border: 1px solid #dee2e6;">&nbsp;</td>
                    <td style="border: 1px solid #dee2e6;">&nbsp;</td>
                    <td style="border: 1px solid #dee2e6;">&nbsp;</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->idno}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->ssite?$user->ssite->title:''}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->applyreason}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->address}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->driver_no}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->emergency_contact}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->emergency_phone}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->company_name}}</td>
                    <td style="border: 1px solid #dee2e6;">{{$user->company_no}}</td>
                    {{--<td style="width: 5%;border: 1px solid #dee2e6;">{{$product->partner?$product->partner->address:''}}</td>--}}
                </tr>
            @endif
    @endforeach
    </tbody>
</table>
