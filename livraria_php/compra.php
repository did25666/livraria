<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();    
} 
include "cart-number.php";
?>

<html>
    <head>
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.js" type="text/javascript"></script>
        <script src="js/paginacao.js" type="text/javascript"></script>
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
        <!-- Bootstrap -->
        <link href="bootstrap-3.3.5-dist/css/bootstrap.css" rel="stylesheet">


        <title>Livraria Infinite</title>
    </head>
    <body>
        <nav class="navbar navbar-inverse">
<div class="navbar-header" id="corpo1">
            <a class="navbar-brand" href="#"><img  src="images/globalheader_logo.png" alt="Livraria infinite"> </a>
    </div>
<div class="container-fluid">

    
    <div id="corpo2"><ul class="nav navbar-nav navbar-right"><?php if (!isset($_SESSION['login'])){ ?>
        <li><button class="btn btn-link" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span> Login</button></li>
        <li><form action="cadastro_cliente.php"><input type="submit" class="btn btn-link" on-click="location.href='cadastro_cliente.php'" value="Registre-se"> </form></li>
<?php }else{?>
        
        <li><label class="btn btn-link" data-toggle="modal" data-target="#myModal"> Olá <?php echo($_SESSION['login']); ?>!</label></li>
        <li><form action="index.php"><a type="submit" class="btn btn-link" href="index.php?id=2">Sair</a> </form></li>
<?php }?>
        <script>
            
                <?php
                   if(is_numeric($_GET["id"])){
                        session_destroy();
                        header('location:index.php');
                    }
                  
                ?>
            
        </script>        
        
        

      </ul></div>
</div>
  <div class="container-fluid" id="corpo2">
    
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Pagina Inicial</a></li>
        <li><a href="#">Sobre</a></li>
        <li><a href="#">Suporte</a></li>
      </ul>

    </div>
  </div>
</nav>
<nav class="navbar navbar-default" role="navigation" id="cabecalho">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
</div>

  <div class="collapse navbar-collapse navbar-ex1-collapse" >
    <ul class="nav navbar-nav">
        
        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">Categorias<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Ação</a></li>
            <li><a href="#">Aventura</a></li>
            <li><a href="#">Humor</a></li>
            <li><a href="#">Romance</a></li>
          </ul>
      </li>
          <li><a href="#">Outros produtos</a></li>
    </ul>
    <form class="navbar-form navbar-left" role="search" action="search_livro.php" method="GET">
        <div class="form-group has-feedback has-feedback-left">
        <input type="text" class="form-control" placeholder="Procure aqui" name="livro" size ="40">
        <a href="#"><i class="form-control-feedback glyphicon glyphicon-search"></i></a>
        </div>
        <button type="submit" class="btn btn-default">Procurar</button>
    </form>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#">WishList</a></li>
      <li><a href="compra.php">
        <span class="glyphicon glyphicon-shopping-cart" style="color:#000">
            <?php
                if($quant != 0){
                    echo"<span class='rw-number-notification'>" .$quant. "</span>";
                }
            ?>
            </span>
      </a></li>
            <li><a href="lista_compras.php">Histórico de Compras</a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Login</h4>
        </div>
        
        <div class="modal-body">
        <form class="navbar-form navbar-left" role="form" method="post" action="ope.php">
          <label>E-mail: </label><input type="email" name="login" class="form-control" placeholder="Email"><br>
          <label>Senha: </label><input type="password" name="senha" class="form-control" placeholder="Senha"><br>
          <a href="#" style="align-self:center"> Esqueci minha senha</a>
          <p>Caso ainda não é cliente <a href="cadastro_cliente.php" style="align-self:center"> Clique aqui</a> e cadastre-se
          <br><br>
          <button type="submit" class="btn btn-default">Entrar</button>
          <button type="button" class="btn btn-default">Cancelar</button>
        </form>  
        </div>
        <div class="modal-footer">
          
          </div>
          
        </div>

      </div>
      
    </div>
        
<?php
    include 'conection.php';
    $sever = $_SESSION['ID'];
    $result = mysqli_query($conn, "SELECT * FROM `carrinho` WHERE `id_cliente` = ".$sever);
    if($result === FALSE) { 
      echo "<h3>Carrinho vazio</h3>";
    }
    
else {
    $i = 0;
    $total = 0;
    echo  '<ul class="list-group">
        <li class="list-group-item"><div class="col-sm-2">Nome</div>
        <div class="col-sm-2">Autor</div>
        <div class="col-sm-2">Preço</div>
        <div class="col-sm-2">Quantidade</div>
        <div class="col-sm-2">Excluir</div>
  </li>';
  // as of php 5.4 mysqli_result implements Traversable, so you can use it with foreach
  foreach( $result as $row2 ) {
    $result2 = mysqli_query($conn, "SELECT * FROM `livro` WHERE `id` = ".$row2['ID_LIVRO']);
    $row = mysqli_fetch_array($result2);
    $result5 = mysqli_query($conn, "SELECT * FROM `livro_autor` WHERE `ID_LIVRO` = ".$row2['ID_LIVRO']);
    $row5 = mysqli_fetch_array($result5);
    $result3 = mysqli_query($conn, "SELECT * FROM `autor` WHERE `id` = ".$row5['ID_AUTOR']);
    $row3 = mysqli_fetch_array($result3);
    
    echo 
  "<li class='list-group-item'>"
    . "<div class='col-sm-2'>" .$row['NOME']. "</div>"
    . "<div class='col-sm-2'> " .$row3['NOME']. "</div>"
    . "<div class='col-sm-2' id='preco" .$i. "'> R$" .$row['PRECO']. "</div>"
    . "<div class='col-sm-2'><input type='number' onchange='update(this.value)' id='qtd" .$i. "' value= '" .$row2['qtd']. "' /></div>"
    . "<div class='col-sm-2'><a href='excluir_carrinho.php?id= + " .$row2['ID']. "'><span style='color: #FD0004' class='glyphicon glyphicon-remove'></span></a></div>"
                    
  . "</li>";
    $i++;
    
    $total += $row['PRECO'];
}
echo"<p id='totalprod' style='display:none'>" .$i."</p>";
    echo  '<ul class="list-group">
        <li class="list-group-item"><div class="col-sm-2">Total</div>
        <div class="col-sm-2"></div>
        <div class="col-sm-2" id="total"> R$' .$total. '</div></div>
  </li>';

}
if(isset($_SESSION['ID'])){
?>
        <div class="form-group" style="padding-top: 20px"> 
        <div class="col-sm-offset-2 col-sm-10">
            <form style="display: inline-block" action="final.php" method="POST">
                <input type="submit" class="btn btn-default" name="insert" value="Finalizar Compra"/>        
            </form>
        <div class="col-sm-7">
            <form  style="display: inline-block" action="index.php" method="POST">
              <input type="submit" class="btn btn-default" name="select" value="Continuar a comprar"/>
          </form>   
        </div>
        </div>
  </div>
        
<?php }  else { ?>
        <h4>É preciso logar para proceder com a compra ou colocar na lista de desejo</h4> 

<?php } ?>
    </body>
        </html>