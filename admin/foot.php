<?php global $Pagina; ?>

<br><br>

<?php if ($tipo == 'grid') { ?>
    <!-- Fim da Grid -->
    <p>
        <a href="?page=<?php echo ($Pagina - 1) . GetQuery(null) ?>">Página Anterior</a>
        - <?php echo $Pagina ?> - 
        <a href="?page=<?php echo ($Pagina + 1) . GetQuery(null) ?>">Próxima Página</a>
    </p>
<?php } ?>

</fieldset>
<!-- Fim Div wrapper -->
</div>
<div class="row">
    <div class="col-sm-12" style="margin-top: 50px"></div>
    <div class="footer">
        <div class="col-md-6 text-left">
            <small><b>Copyright</b> ASIX6</small>
        </div>
        <div class="col-md-6 text-right">
            <small>© 2016</small>
        </div>
    </div>
</div>
</div>