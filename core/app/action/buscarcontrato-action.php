<?php
$contrato = ContratoAguaData::getByCode($_GET['code']);

if($contrato==null){
   // echo "id";
$contrato = ContratoAguaData::getById($_GET['code']);    
}

if($contrato):
$client = ClientData::getById($contrato->client_id);

?>
<!--                        <form role="form" method="post" action="./?action=cobrosagua&opt=add" enctype="multipart/form-data"> -->
                        <form role="form" method="post" id="cobro_form" enctype="multipart/form-data">
                            <input type="hidden" name="client_id" value="<?php echo $client->id; ?>">
                            <input type="hidden" name="contrato_agua_id" value="<?php echo $contrato->id; ?>">
                            <input type="hidden" name="tipo_contrato" value="<?php echo $contrato->tipo_contrato; ?>">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
<div class="row">
    <div class="col-md-3">
                            <div class="form-group">
                                <label><b># Contrato</b></label>
                                <input type="text" name="contrato_agua" readonly value="<?php echo $contrato->code; ?>" class="form-control" placeholder="# contrato">
                            </div>
    </div>
    <div class="col-md-3">
                            <div class="form-group">
                                <label><b>Fecha</b></label>
                                <input type="date" value="<?php echo date("Y-m-d"); ?>" <?php if(Core::$user->kind==9):?>readonly<?php endif;?> name="date_at" class="form-control" placeholder="Fecha">
                            </div>
    </div>


<div class="col-md-3">
                            <div class="form-group">
                                <label><b>Cliente</b></label>
      
      <p><?php echo $client->name." ".$client->name2." ".$client->lastname." ".$client->lastname2; ?></p>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="form-group">
                                <label><b>Tipo de Contrato</b></label>
<p>
<?php if($contrato->tipo_contrato==1){
                                                    echo "Domestico";
                                                } 
                                                else if($contrato->tipo_contrato==2){
                                                    echo "Comercial";
                                                }else if($contrato->tipo_contrato==3){
                                                    echo "Industrial";
                                                }

                                            ?>
                                        </p>
                            </div>
                        </div>
                        </div>

<div class="row">

<div class="col-md-8">
    <div class="form-group">
                                <label><b>Concepto / Tipo de Servicio</b></label>
      
      <select name="tipo_servicio_id" id="tipo_servicio_id"  required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(TipoServicioData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>
                            </div>
</div>

<div class="col-md-4">
                                <div class="form-group">
                                <label><b>Periodo</b></label>
      
      <select name="periodo_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(PeriodoData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>
                            </div>
</div>

</div>



                            

<script type="text/javascript">
    $("#tipo_servicio_id").change(function(){
        $.get("./?action=gettiposervicio","id="+$("#tipo_servicio_id").val(),function(data){
            $("#amount").val(data);
            $("#total").val(data);
        });
    });
</script>


<div class="row">
    <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Monto</b></label>
                                <input type="text" value="0" required readonly name="amount" id="amount" class="form-control" placeholder="Monto">
                            </div>
    </div>
    <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Descuento %%</b></label>
      <select name="descuento" id="descuento" required class="form-control" required>
        <option value="0">-- SELECCIONE --</option>
<?php foreach(DescuentoData::getAll() as $k):?>
<option value="<?php echo $k->name; ?>"><?php echo $k->name; ?></option>
<?php endforeach; ?>

      </select>
                            </div>
    </div>
    <div class="col-md-4">
                            <div class="form-group">
                                <label><b>Incluir IVA 16% ?</b></label>
      <select name="iva" id="iva" required class="form-control" required>
        <option value="0">NO</option>
<option value="16">SI</option>

      </select>
                            </div>
    </div>
</div>




<div class="row">
    <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Total a Pagar</b></label>
                                <input type="text" value="" required readonly name="total" id="total" class="form-control" placeholder="Total a pagar">
                            </div>

    </div>
    <div class="col-md-6">
        
                                <div class="form-group">
                                <label><b>Forma de Pago</b></label>
      
      <select name="forma_pago_id" required class="form-control" required>
        <?php foreach(FormaPagoData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>
                            </div>

    </div>
</div>


<script>
    $("#descuento").change(function(){
        val= $("#amount").val();
        iva= $("#iva").val();
        if(val>0){
        desc= $("#descuento").val();

        tot = val - (val * desc/100);
        $("#total").val(tot + (tot * iva /100));

        }else{
            alert("Debes elegir un Concepto de Pago!")
        }
    });

    $("#iva").change(function(){
        val= $("#amount").val();
        iva= $("#iva").val();
        if(val>0){
        desc= $("#descuento").val();

        tot = val - (val * desc/100);
        $("#total").val(tot + (tot * iva /100));

        }else{
            alert("Debes elegir un Concepto de Pago!")
        }
    });


</script>
                            <div class="form-group">
                                <label><b>Descripcion</b></label>
                                <textarea name="description" class="form-control" placeholder="Descripcion"></textarea>
                            </div>
<br>
                            <button type="submit" class="btn btn-success">Agregar a la Lista</button>

                        </form>
<script type="text/javascript">
    $("#cobro_form").submit(function(e){
        e.preventDefault();
        $.post("./?action=addtocobroslist",$("#cobro_form").serialize(), function(data){
            console.log("cart :"+ data);


        $.get("./?action=getcobrolist","", function(data2){

            $("#cobro_list").html(data2);
        });

    });

    });
</script>

<div id="cobro_list"></div>


                        <?php else:?>
                            <p class="alert alert-danger">No se encontro el contrato</p>
                            <?php endif; ?>