<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <thead>
    <tr>
        <th>Abreviatura</th>
        <th>Nombre</th>
        <th>Descripcion</th>
    </tr>
    </thead>
    <tbody>
      @foreach($lineas as  $linea)
      
        <tr>
            <td>
                {{isset($linea) ? $linea->abreviatura : 'No registra'}}
            </td>
            <td>
                {{ isset($linea) ? $linea->nombre : 'No registra'}} 
            </td>
            <td>
                {{isset($linea)? $linea->descripcion: 'No registra'}}
            </td>
            
          
        </tr>
       
      @endforeach
    </tbody>
</table>