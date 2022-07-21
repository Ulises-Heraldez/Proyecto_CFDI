<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

?>


<!doctype html>
<html>

<head>
    <title>Analizar CFDIs</title>
    <link rel="stylesheet" href="css/estilo.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>

<body>
    <div class="container">

        <h1>Analizador CFDIs de: <?php echo $user_data['nombre']; ?></h1>

        <div id="app">

            <aside2>

                <div id="drop" class="subir_archivos" ref="drop">Arrastre para subir archivos XML</div>

                <br><br>

                <div class="row">
                    <div class="col-sm">
                        <table class="table table-striped table-bordered table-hover margenb" id="totales" ref="totales" style="width:320px">
                            <tbody>
                                <tr>
                                    <th>Cantidad XML</th>
                                    <td>{{cantidad}}</td>
                                </tr>
                                <tr>
                                    <th>Ingresos:</th>
                                    <td>{{total_ingresos}}</td>
                                </tr>
                                <tr>
                                    <th>Egresos:</th>
                                    <td>{{total_egresos}}</td>
                                </tr>
                                <tr>
                                    <th>Traslados:</th>
                                    <td>{{total_traslados}}</td>
                                </tr>
                                <tr>
                                    <th>Nómina:</th>
                                    <td>{{total_nomina}}</td>
                                </tr>
                                <tr>
                                    <th>Pago:</th>
                                    <td>{{total_pago}}</td>
                                </tr>
                                <tr>
                                    <th>IVA:</th>
                                    <td>${{total_iva.toFixed(2)}}</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>${{total_suma.toFixed(2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>

                        <a href="historial.php"><button>Historial</button></a>

                        <br><br>

                        <a href="logout.php"><button class="logout_cargar">Logout</button></a>

                       



                    </div>
                    <div class="col-sm">
                        <div v-if="errores.length" class="alert alert-warning">
                            <h3>Errores:</h3>
                            <ul>
                                <li v-for="error in errores">{{error.archivo}}: {{error.mensaje}}</li>
                            </ul>
                        </div>
                    </div>
                </div>





            </aside2>




            <aside>
                <b>Buscar: </b>

                <input type="text" id="buscar" class="form-control" placeholder="Buscar algo">

                <input type="button" class="subir_archivos" value="Exportar a excel" onclick="exportTableToExcel('tabla','Reporte_de_CFDIs')">

                <input class="subir_archivos" type="button" value="Guardar datos" onclick="mostrarJson()">


                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tabla" ref="tabla">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>tipo</th>
                                <th>serie</th>
                                <th>Fact</th>
                                <th>Razón social</th>
                                <th>Importe excento</th>
                                <th>Importe gravado</th>
                                <th>iva</th>
                                <th>Importe retenido</th>
                                <th>Total</th>
                                <th>RFC para DIOT</th>
                                <th>Concepto del gasto</th>
                                <th>Nombre receptor</th>
                                <th>RFC Receptor</th>
                                <th>Nombre del archivo XML</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_xml">
                            <tr v-for="cfdi in cfdis">
                                <td>{{cfdi.fecha}}</td>
                                <td>{{cfdi.tipo}}</td>
                                <td>{{cfdi.serie}}</td>
                                <td>{{cfdi.fact}}</td>
                                <td>{{cfdi.nombre}}</td>
                                <td>{{cfdi.excento}} $</td>
                                <td>{{cfdi.sub_total}} $</td>
                                <td>{{cfdi.iva}} $</td>
                                <td>{{cfdi.descuento}} $</td>
                                <td>{{cfdi.total_importe}} $</td>
                                <td>{{cfdi.rfc}}</td>
                                <td>
                                    <div v-for="concepto in cfdi.conceptos" class="concepto">
                                        {{concepto.cantidad}}
                                        {{concepto.descripcion}}
                                        ${{concepto.importe.toFixed(2)}} $
                                        <span v-for="traslado in concepto.traslados" class="traslado">
                                            {{traslado.tipo}}
                                            {{traslado.tasa}}
                                        </span>
                                    </div>
                                </td>
                                <td>{{cfdi.nombre_receptor}}</td>
                                <td>{{cfdi.rfc_receptor}}</td>
                                <td>{{cfdi.archivo}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <script>
                        //Buscar elementos
                        $(document).ready(function() {
                            $("#buscar").on("keyup", function() {
                                var value = $(this).val().toLowerCase();
                                $("#tabla_xml tr").filter(function() {
                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                });
                            });
                        });
                        $(function() {
                            $("#tabla").makeSortable();
                        });
                    </script>
                    <!-- {{ message }} -->
                    <!-- <pre>{{$data }}</pre> -->
                </div>













            </aside>
        </div>

        <!-- jquery -->
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

        <!-- vue -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.min.js"></script>

        <script src="js/cargarxml.js"></script>
        <script src="js/main.js"></script>

</body>

</html>




<script>
    function exportTableToExcel(tableID, filename = '') {
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename ? filename + '.xls' : 'excel_data.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

            // Setting the file name
            downloadLink.download = filename;

            //triggering the function
            downloadLink.click();
        }
    }

    function limpiar_tabla() {
        var table = document.getElementById("tabla_xml");
        var rowCount = table.rows.length;

        if (rowCount < 1)
            alert('No se puede eliminar el encabezado');
        else
            table.deleteRow(rowCount - 1);
    }
</script>
<script>
    //Ordenar tabla
    (function($) {
        $.fn.extend({
            makeSortable: function() {
                var MyTable = this;
                var getCellValue = function(row, index) {
                    return $(row).children('td').eq(index).text();
                };
                MyTable.find('th').click(function() {
                    var table = $(this).parents('table').eq(0);
                    // Sort by the given filter
                    var rows = table.find('tr:gt(0)').toArray().sort(function(a, b) {
                        var index = $(this).index();
                        var valA = getCellValue(a, index),
                            valB = getCellValue(b, index);
                        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
                    });
                    this.asc = !this.asc;
                    if (!this.asc) {
                        rows = rows.reverse();
                    }
                    for (var i = 0; i < rows.length; i++) {
                        table.append(rows[i]);
                    }
                });
            }
        });
    })(jQuery);
</script>


<script type="text/javascript">
    function tableToJson(table) {
        var data = [];
        var headers = [];

        for (var i = 0; i < table.rows[0].cells.length; i++) {
            headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi, '');
        }

        for (var i = 0; i < table.rows.length; i++) {
            var tableRow = table.rows[i];
            var rowData = {};
            for (var j = 0; j < tableRow.cells.length; j++) {
                rowData[headers[j]] = tableRow.cells[j].innerText;
            }
            data.push(rowData);
        }

        var datos = {
            "data": data
        };
        return datos;
    }

    function mostrarJson() {
        var myJson = JSON.stringify(tableToJson(document.getElementById("tabla")));
        _ajax("guardar_datos.php", {
                "json": myJson
            })
            .done(function(info) {
                console.log(info);
            });
    }

    function _ajax(url, data) {
        alert("Se guardó con éxito");
        var ajax = $.ajax({
            "method": "POST",
            "url": "guardar_datos.php",
            "data": data
        })

        return ajax;
    }
</script>
</body>

</html>