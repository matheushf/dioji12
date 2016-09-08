<?php
include 'head.php';
?>

<div class="container">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 sugestao-intro text-center">


            <h2 class="sugestao-quantidade"><b>66</b> Sugestões </h2>

            <h3 class="sugestao-titulo"> ENVIE SUA SUGESTÃO PARA DIOJI12 </h3>

            <div class="form-group">

                <select class="form-control" name="area">
                    <option value="">Selecione uma área</option>
                </select>
            </div>

            <div class="form-group">
                <textarea class="form-control" rows="5" placeholder="Escreva uma sugestão.."></textarea>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="nome" placeholder="Seu nome.."/>
            </div>
            <div class="form-group">

                <input type="text" class="form-control" name="celular" placeholder="(62) 0000-0000.."/>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-enviar">ENVIAR SUGESTÃO</button>
            </div>

        </div>
    </div>
</div>

<?php
include 'foot.php';
?>