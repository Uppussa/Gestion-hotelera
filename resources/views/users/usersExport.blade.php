<div id="container">
    <div id="body" style="margin-top: 0px;">
        <table cellspacing="0" cellpadding="1" border="0" style="border:0px none black;">
            <tr>
                <td style="text-align:left;">
                    <img src="{{ asset('public/app/images/logo.png')}}" height="40">
                </td>
                <td style="text-align:right;" width="80%">
                    <span style="font-size:15px;">Reporte en PDF de usuarios</span><br>
                    <span style="font-size:13px;">Generado el día <?=fecha(todayMasD(0))?></span>
                </td>
            </tr>
        </table>
        @php
        $regs = getSession('regUsersExp');
        @endphp
        @if (count($regs)>0)
            <table  class="mt-3">
                <thead>
                    <tr style="border-bottom:1px solid;">
                        <th width="5%">#</th>
                        <th width="30%">Nombre</th>
                        <th width="30%">Email</th>
                        <th width="25%">Estatus</th>
                        <th width="10%">Tipo</th>
                        <th width="15%">Registro</th>
                    </tr>
                </thead>
                <tbody id="fileList">
                    @foreach ($regs as $reg)
                        <tr style="border-bottom:1px solid gray;">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$reg->name}}</td>
                            <td>{{$reg->email}}</td>
                            <td>{{activeReg($reg->status)}}</td>
                            <td>{{tipoUser($reg->level->level)}}</td>
                            <td>{{fecha($reg->created_at)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-center mt-4">Sin resultados</p>
        @endif
    </div>
</div>
