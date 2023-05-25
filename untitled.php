<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script type="text/javascript">
function isValidDate(day,month,year)
{
    var dteDate;
 
    // En javascript, el mes empieza en la posicion 0 y termina en la 11 
    //   siendo 0 el mes de enero
    // Por esta razon, tenemos que restar 1 al mes
    month=month-1;
    // Establecemos un objeto Data con los valore recibidos
    // Los parametros son: año, mes, dia, hora, minuto y segundos
    // getDate(); devuelve el dia como un entero entre 1 y 31
    // getDay(); devuelve un num del 0 al 6 indicando siel dia es lunes,
    //   martes, miercoles ...
    // getHours(); Devuelve la hora
    // getMinutes(); Devuelve los minutos
    // getMonth(); devuelve el mes como un numero de 0 a 11
    // getTime(); Devuelve el tiempo transcurrido en milisegundos desde el 1
    //   de enero de 1970 hasta el momento definido en el objeto date
    // setTime(); Establece una fecha pasandole en milisegundos el valor de esta.
    // getYear(); devuelve el año
    // getFullYear(); devuelve el año
    dteDate=new Date(year,month,day);
 
    //Devuelva true o false...
    return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
}
 
/**
 * Funcion para validar una fecha
 * Tiene que recibir:
 *  La fecha en formato ingles yyyy-mm-dd
 * Devuelve:
 *  true-Fecha correcta
 *  false-Fecha Incorrecta
 */
function validate_fecha(fecha)
{
    var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");
 
    if(fecha.search(patron)==0)
    {
        var values=fecha.split("-");
        if(isValidDate(values[2],values[1],values[0]))
        {
            return true;
        }
    }
    return false;
}
 
/**
 * Esta función calcula la edad de una persona y los meses
 * La fecha la tiene que tener el formato yyyy-mm-dd que es
 * metodo que por defecto lo devuelve el <input type="date">
 */
function calcularEdad()
{
    var fecha=document.getElementById("fecha_nacimiento").value;
    
        // Si la fecha es correcta, calculamos la edad
        var values=fecha.split("-");
        var dia = values[2];
        var mes = values[1];
        var ano = values[0];
 
        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth()+1;
        var ahora_dia = fecha_hoy.getDate();
 
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if ( ahora_mes < mes )
        {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia))
        {
            edad--;
        }
        if (edad > 1900)
        {
            edad -= 1900;
        }
 
        // calculamos los meses
        var meses=0;
        if(ahora_mes>mes)
            meses=ahora_mes-mes;
        if(ahora_mes<mes)
            meses=12-(mes-ahora_mes);
        if(ahora_mes==mes && dia>ahora_dia)
            meses=11;
 
        // calculamos los dias
        var dias=0;
        if(ahora_dia>dia)
            dias=ahora_dia-dia;
        if(ahora_dia<dia)
        {
            ultimoDiaMes=new Date(ahora_ano, ahora_mes, 0);
            dias=ultimoDiaMes.getDate()-(dia-ahora_dia);
        }

//selecciono la categoria que corresponda, segun el año
		 //si estamos en enero o febrero, veo cuando cumple el niño
		var edadCategoria=edad;
		if (((12 - meses) + ahora_mes) <= 12) 
		{edadCategoria = edad + 1} //le sumo un año para contarlo en la categoria sig			
				
		//selecciono la categoria correspondiente a esa edad
		if (edadCategoria<=6)
		{ document.forms["form1"]["idcategoria"].value = 1}
		else if (edadCategoria==7)
		{ document.forms["form1"]["idcategoria"].value = 2}
		else if (edadCategoria==8)
		{ document.forms["form1"]["idcategoria"].value = 3}
		else if (edadCategoria==9)
		{ document.forms["form1"]["idcategoria"].value = 4}
		else if (edadCategoria==10)
		{ document.forms["form1"]["idcategoria"].value = 5}
		else if (edadCategoria==11)
		{ document.forms["form1"]["idcategoria"].value = 6}
		else if (edadCategoria==12)
		{ document.forms["form1"]["idcategoria"].value = 7}
		else if (edadCategoria==13)
		{ document.forms["form1"]["idcategoria"].value = 8}
 
 //no muestro la variable dias
        document.getElementById("result").innerHTML=edad+" años y "+meses+" meses";
//		document.getElementById("result").innerHTML="Tienes "+ano+" años y "+mes+" meses";
		
    }	
	
	
	
function contar() 
{
		document.getElementById("result").innerHTML=" años y ";
var checkboxes = document.getElementById("form1").checkbox;
var cont = 0;
	 
	
 
	for (var x=0; x < checkboxes.length; x++) {
	 if (checkboxes[x].checked) {
	  cont = cont + 1;
	 }
	}

	
	
}
	
</script>

</head>

<body>
<form method="post" name="form1" action="">
          <table align="center">
          
          <tr valign="baseline">
              <td nowrap align="right">Fecha de nacimiento:</td>
              
              <td><input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="2017/04/17" size="32">
              <!-- al seleccionar la fecha de nacimiento, coloco automaticamente la categoria que pertenece -->
 
 		
              
              </td>
            </tr>
            
          
          
          
<tr valign="baseline">
              <td nowrap align="right">Mes de pago:</td>
              <td align="left">              
             
              <table width="100">
                <tr>
                
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="1" id="mes_pago_0" onClick="contar();">
                    Enero</label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="2" id="mes_pago_1" onClick="contar();">
                    Febrero</label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="3" id="mes_pago_2" onClick="javascript:contar();">
                    Marzo </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="4" id="mes_pago_3" onClick="javascript:contar();">
                    Abril </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="5" id="mes_pago_4" onClick="javascript:contar();">
                    Mayo </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="6" id="mes_pago_5" onClick="javascript:contar();">
                    Junio </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="7" id="mes_pago_6" onClick="javascript:contar();">
                    Julio </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="8" id="mes_pago_7" onClick="javascript:contar();">
                    Agosto </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="9" id="mes_pago_8" onClick="javascript:contar();">
                    Setiembre </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="10" id="mes_pago_9" onClick="javascript:contar();">
                    Octubre </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="11" id="mes_pago_10" onClick="javascript:contar();">
                    Noviembre </label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="checkbox" name="mes_pago" value="12" id="mes_pago_11" onClick="javascript:contar();">
                    Diciembre </label></td>
                </tr>
              </table>
                                                      
              </td>
              
            </tr>
            
            
             <tr valign="baseline">

              <!-- calculo la cantidad de meses marcados *200 y lo pongo en value-->
              <td>
              
            <input type="button" value="Edad y Categoría" onclick="javascript:contar();" >
        <a id="result"> </a>
        
        
            </td>
 
            </tr>
            </table>
            </form>
</body>
</html>