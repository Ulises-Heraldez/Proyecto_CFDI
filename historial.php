<?php
//index.php

$conn = mysqli_connect('localhost', 'root', '200019', 'cfdi');

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);
?>

<!doctype html>
<html>

<head>
    <title>Historial CFDIs</title>
    <link rel="stylesheet" href="css/estilo.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>




<body>
    <div class="container">

        <h1>Historial CFDIs del usuario: <?php echo $user_data['nombre']; ?></h1>

        <h1>Buscar:
            <div class="search-box">
                <input type="text" id="buscar" autocomplete="off" placeholder="Buscar cualquier dato..." />
                <div class="result"></div>
                
                <br>
                
                <div class="botones">
                    <a href="index.php"><button class="regresar_historial">Analizador</button></a>
                    <a href="logout.php"><button class="logout_historial">Logout</button></a>
                </div>

                <br><br><br>

            </div>
        </h1>






        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tabla" ref="tabla" style="color: aliceblue; scroll-behavior: auto;">
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
                    </tr>
                </thead>
                <tbody id="tabla_xml">
                    <?php
                    include('connection.php');

                    
                    $id = $_SESSION['id_usuario'];

                    $sql = "SELECT * from tb_cfdis WHERE id_usuario = '$id'";
                    $resul = mysqli_query($con, $sql);

                    while ($mostrar = mysqli_fetch_array($resul)) {
                    ?>
                        <tr>
                            <td><?php echo $mostrar['fecha'] ?></td>
                            <td><?php echo $mostrar['tipo'] ?></td>
                            <td><?php echo $mostrar['serie'] ?></td>
                            <td><?php echo $mostrar['fact'] ?></td>
                            <td><?php echo $mostrar['razon_social'] ?></td>
                            <td><?php echo $mostrar['importe_excento'] ?></td>
                            <td><?php echo $mostrar['importe_gravado'] ?></td>
                            <td><?php echo $mostrar['iva'] ?></td>
                            <td><?php echo $mostrar['importe_retenido'] ?></td>
                            <td><?php echo $mostrar['total'] ?></td>
                            <td><?php echo $mostrar['rfc_para_diot'] ?></td>
                            <td><?php echo $mostrar['concepto'] ?></td>
                            <td><?php echo $mostrar['nombre_receptor'] ?></td>
                            <td><?php echo $mostrar['rfc_receptor'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <br><br>












</body>

</html>



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
<script>
    function searchDate() {
        var input_startDate, input_stopDate, tr, i;
        // get the values and convert to date
        input_startDate = new Date(document.getElementById("a").value);
        input_stopDate = new Date(document.getElementById("b").value);

        tr = document.querySelectorAll("#tabla tbody tr");

        for (let i = 0; i < tr.length; i++) {
            // ensure we have a relevant td
            let td = tr[i].getElementsByTagName("td");
            if (!td || !td[0]) continue;

            // you need to get the text and convert to date
            let td_date = new Date(td[0].textContent);


            // now you can compare dates correctly
            if (td_date) {
                if (td_date >= input_startDate && td_date <= input_stopDate) {
                    // show the row by setting the display property
                    tr[i].style.display = 'table-row;';
                } else {
                    // hide the row by setting the display property
                    tr[i].style.display = 'none';
                }
            }
        }
    }
</script>
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
        var table = document.getElementById("tablita");
        var rowCount = table.rows.length;

        if (rowCount < 1)
            alert('No se puede eliminar el encabezado');
        else
            table.deleteRow(rowCount - 1);
    }

    function prueba() {
        console.log("<?php echo $id ?>");
        console.log("Pruebas")
    }
</script>