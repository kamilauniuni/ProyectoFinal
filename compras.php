<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Supermercados Osmar</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="stilos.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="responsive.css" type="text/css">
    <header>
    <div class="contenedorglobal">
    <header>
    <div class="container-fluid bg-white">
        <div class="row align-items-center">
        <div class="container-fluid bg-white">
       <div class="row align-items-center">
           <div class="col-12 col-md-6 text-start">
            <h1 class="ms-3">SupermercadosOsmar
                <img src="img/carrito-de-compras (1).png" alt="Icono" style="vertical-align: middle; width: 35px; height: 35px;">
            </h1>
             </div>
            <div class="col-12 col-md-6">
                <nav class="navbar navbar-expand-lg bg-body">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-start" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.php">Hogar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="catalogo.php">Catálogo</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="sobreNosotros.php">Quiénes somos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="contactanos.php">Contáctenos</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php 
                                            if (isset($_SESSION['nombre'])) {
                                                echo $_SESSION['nombre'];
                                            } else {
                                                echo '<img src="img/perfil8.png" alt="" class="usuario" style="vertical-align: middle; width: 25px; height: 25px;">';
                                            }
                                        ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php 
                                            if (isset($_SESSION['nombre'])) {
                                                echo '<li><a class="dropdown-item" href="perfil.php">Perfil</a></li>';
                                                echo '<li><a class="dropdown-item" href="login/controlador/controlador_cerrar_session.php">Salir</a></li>';
                                            } else {
                                                echo '<li><a class="dropdown-item" href="login/login.php">Iniciar sesión</a></li>';
                                            }
                                        ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
   
   
 
</head>
<body>

  <!--inicio del carro de compras-->
	<div class="cart-page-content page-section-padding">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="cart_title">
						<h4>Mi carrito de Compras</h4>
					</div>
					<div class="table-responsive">
						<table class="cart-table text-center">
							<thead>
								<tr id="cart_th">
									<th>#</th>
									<th>Imagen</th>
									<th>Producto</th>
									<th>Cantidad</th>
									<th>Precio Unitario ($)</th>
									<th>Total ($)</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody>
                  <tr data-item="1">
									<td>1</td>
									<td>
                    <img src="img/fresa.png" alt="" class="img-item">
									</td>
									<td>
										<h6><a>fresas (1 kl)</a></h6>
									</td>
									<td>
										<form id="qua_in" action="action_page.php">
											<input id="cant1" onchange="changeQuantity(1)" type="number" value="1" name="quantity" min="1" max="5">
										</form>
									</td>
									<td>
										<div class="cart-price" id="price1">3400</div>
									</td>
									<td>
										<div id="subtotal1" class="cart-subtotal">3400</div>
									</td>
									<td>
                                        <button class="bin-button" onclick="removeItem(1)">
                                            <svg
                                              class="bin-top"
                                              viewBox="0 0 39 7"
                                              fill="none"
                                              xmlns="http://www.w3.org/2000/svg"
                                            >
                                              <line y1="5" x2="39" y2="5" stroke="white" stroke-width="4"></line>
                                              <line
                                                x1="12"
                                                y1="1.5"
                                                x2="26.0357"
                                                y2="1.5"
                                                stroke="white"
                                                stroke-width="3"
                                              ></line>
                                            </svg>
                                            <svg
                                              class="bin-bottom"
                                              viewBox="0 0 33 39"
                                              fill="none"
                                              xmlns="http://www.w3.org/2000/svg"
                                            >
                                              <mask id="path-1-inside-1_8_19" fill="white">
                                                <path
                                                  d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"
                                                ></path>
                                              </mask>
                                              <path
                                                d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                                                fill="white"
                                                mask="url(#path-1-inside-1_8_19)"
                                              ></path>
                                              <path d="M12 6L12 29" stroke="white" stroke-width="4"></path>
                                              <path d="M21 6V29" stroke="white" stroke-width="4"></path>
                                            </svg>
                                          </button>
                                      </td>
								</tr>
								<tr data-item="2">
									<td>2</td>
									<td>
                    <img src="img/banano.png" alt="" class="img-item">
									</td>
									<td>
										<h6><a>Lorem ipsum dolor sit amet,</a></h6>
									</td>
									<td>
										<form id="qua_in_2" action="action_page.php">
											<input id="cant2" onchange="changeQuantity(2)" type="number" value="1" name="quantity" min="1" max="10">
										</form>
									</td>
									<td>
										<div class="cart-price" id="price2">29999</div>
									</td>
									<td>
										<div id="subtotal2" class="cart-subtotal">29999</div>
									</td>
									<td>
                      <button class="bin-button" onclick="removeItem(2)">
                      <svg
                        class="bin-top"
                        viewBox="0 0 39 7"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <line y1="5" x2="39" y2="5" stroke="white" stroke-width="4"></line>
                        <line
                          x1="12"
                          y1="1.5"
                          x2="26.0357"
                          y2="1.5"
                          stroke="white"
                          stroke-width="3"
                        ></line>
                      </svg>
                      <svg
                          class="bin-bottom"
                          viewBox="0 0 33 39"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <mask id="path-1-inside-1_8_19" fill="white">
                            <path
                              d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"
                            ></path>
                          </mask>
                          <path
                            d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                            fill="white"
                            mask="url(#path-1-inside-1_8_19)"
                          ></path>
                           <path d="M12 6L12 29" stroke="white" stroke-width="4"></path>
                          <path d="M21 6V29" stroke="white" stroke-width="4"></path>
                        </svg>
                       </button>
                  </td>
								</tr>
								<tr id="total_colspan">
									<td colspan="3" class="text-left"><h5>total</h5></td>
									<td>
										<h5 id="totalCant">2</h5>
									</td>
									<td ><h5 style="display: inline-block;">$ </h5><h5 id="total" style="display: inline-block;">33400</h5></td>
									<td colspan="2">
                  <button class="button" >
                   <a href="https://www.facebook.com/"> comprar ahora
                    <svg class="cartIcon" viewBox="0 0 576 512"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path></svg>
                   </a>  
                  </button>
                    </div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div> 
	<!-- Cart-Page-Content-End -->  
   <!--volver a la categoria-->
   <div class="volver" >
    <a href="catalogo.php">volver</a>
   </div>
     <!--alerta domiciliio-->
    <div class="info">
        <div class="info__icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" height="24" fill="none"><path fill="#393a37" d="m12 1.5c-5.79844 0-10.5 4.70156-10.5 10.5 0 5.7984 4.70156 10.5 10.5 10.5 5.7984 0 10.5-4.7016 10.5-10.5 0-5.79844-4.7016-10.5-10.5-10.5zm.75 15.5625c0 .1031-.0844.1875-.1875.1875h-1.125c-.1031 0-.1875-.0844-.1875-.1875v-6.375c0-.1031.0844-.1875.1875-.1875h1.125c.1031 0 .1875.0844.1875.1875zm-.75-8.0625c-.2944-.00601-.5747-.12718-.7808-.3375-.206-.21032-.3215-.49305-.3215-.7875s.1155-.57718.3215-.7875c.2061-.21032.4864-.33149.7808-.3375.2944.00601.5747.12718.7808.3375.206.21032.3215.49305.3215.7875s-.1155.57718-.3215.7875c-.2061.21032-.4864.33149-.7808.3375z"></path></svg>
        </div>
        <div class="info__title">para el realizar el domicio la compra debe ser superior a $10.000 pesos</div>
     </div>
    
    <!--final -->

    <footer>
        <div class="footer1">
            <div class="contenedor-footer">
                <div class="letra">
                    <h6>SupermercadosOsmar</h6>
                    <p>Tu destino de compras diarias.</p>
                    <img src="img/social.png" width="30px" height="30px" herf="">
                    <img src="img/sobre.png" width="30px" height="30px" herf="">
                    
<div class="loader">
<div class="truckWrapper">
  <div class="truckBody">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 198 93"
      class="trucksvg"
    >
      <path
        stroke-width="3"
        stroke="#282828"
        fill="#F83D3D"
        d="M135 22.5H177.264C178.295 22.5 179.22 23.133 179.594 24.0939L192.33 56.8443C192.442 57.1332 192.5 57.4404 192.5 57.7504V89C192.5 90.3807 191.381 91.5 190 91.5H135C133.619 91.5 132.5 90.3807 132.5 89V25C132.5 23.6193 133.619 22.5 135 22.5Z"
      ></path>
      <path
        stroke-width="3"
        stroke="#282828"
        fill="#7D7C7C"
        d="M146 33.5H181.741C182.779 33.5 183.709 34.1415 184.078 35.112L190.538 52.112C191.16 53.748 189.951 55.5 188.201 55.5H146C144.619 55.5 143.5 54.3807 143.5 53V36C143.5 34.6193 144.619 33.5 146 33.5Z"
      ></path>
      <path
        stroke-width="2"
        stroke="#282828"
        fill="#282828"
        d="M150 65C150 65.39 149.763 65.8656 149.127 66.2893C148.499 66.7083 147.573 67 146.5 67C145.427 67 144.501 66.7083 143.873 66.2893C143.237 65.8656 143 65.39 143 65C143 64.61 143.237 64.1344 143.873 63.7107C144.501 63.2917 145.427 63 146.5 63C147.573 63 148.499 63.2917 149.127 63.7107C149.763 64.1344 150 64.61 150 65Z"
      ></path>
      <rect
        stroke-width="2"
        stroke="#282828"
        fill="#FFFCAB"
        rx="1"
        height="7"
        width="5"
        y="63"
        x="187"
      ></rect>
      <rect
        stroke-width="2"
        stroke="#282828"
        fill="#282828"
        rx="1"
        height="11"
        width="4"
        y="81"
        x="193"
      ></rect>
      <rect
        stroke-width="3"
        stroke="#282828"
        fill="#DFDFDF"
        rx="2.5"
        height="90"
        width="121"
        y="1.5"
        x="6.5"
      ></rect>
      <rect
        stroke-width="2"
        stroke="#282828"
        fill="#DFDFDF"
        rx="2"
        height="4"
        width="6"
        y="84"
        x="1"
      ></rect>
    </svg>
  </div>
  <div class="truckTires">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 30 30"
      class="tiresvg"
    >
      <circle
        stroke-width="3"
        stroke="#282828"
        fill="#282828"
        r="13.5"
        cy="15"
        cx="15"
      ></circle>
      <circle fill="#DFDFDF" r="7" cy="15" cx="15"></circle>
    </svg>
    <svg
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 30 30"
      class="tiresvg"
    >
      <circle
        stroke-width="3"
        stroke="#282828"
        fill="#282828"
        r="13.5"
        cy="15"
        cx="15"
      ></circle>
      <circle fill="#DFDFDF" r="7" cy="15" cx="15"></circle>
    </svg>
  </div>
  <div class="road"></div>

  <svg
    xml:space="preserve"
    viewBox="0 0 453.459 453.459"
    xmlns:xlink="http://www.w3.org/1999/xlink"
    xmlns="http://www.w3.org/2000/svg"
    id="Capa_1"
    version="1.1"
    fill="#000000"
    class="lampPost"
  >
    <path
      d="M252.882,0c-37.781,0-68.686,29.953-70.245,67.358h-6.917v8.954c-26.109,2.163-45.463,10.011-45.463,19.366h9.993
c-1.65,5.146-2.507,10.54-2.507,16.017c0,28.956,23.558,52.514,52.514,52.514c28.956,0,52.514-23.558,52.514-52.514
c0-5.478-0.856-10.872-2.506-16.017h9.992c0-9.354-19.352-17.204-45.463-19.366v-8.954h-6.149C200.189,38.779,223.924,16,252.882,16
c29.952,0,54.32,24.368,54.32,54.32c0,28.774-11.078,37.009-25.105,47.437c-17.444,12.968-37.216,27.667-37.216,78.884v113.914
h-0.797c-5.068,0-9.174,4.108-9.174,9.177c0,2.844,1.293,5.383,3.321,7.066c-3.432,27.933-26.851,95.744-8.226,115.459v11.202h45.75
v-11.202c18.625-19.715-4.794-87.527-8.227-115.459c2.029-1.683,3.322-4.223,3.322-7.066c0-5.068-4.107-9.177-9.176-9.177h-0.795
V196.641c0-43.174,14.942-54.283,30.762-66.043c14.793-10.997,31.559-23.461,31.559-60.277C323.202,31.545,291.656,0,252.882,0z
M232.77,111.694c0,23.442-19.071,42.514-42.514,42.514c-23.442,0-42.514-19.072-42.514-42.514c0-5.531,1.078-10.957,3.141-16.017
h78.747C231.693,100.736,232.77,106.162,232.77,111.694z"
    ></path>
  </svg>
</div>
</div>

                </div>
                <div class="letra">
                    <h5>Dirección</h5>
                    <p><img src="img/marcador-de-alfiler.png" alt="" width="23px" height="23px">Calle 59 #3 -g5 b/la floresta</p>
                    <p><img src="img/marcador-de-alfiler.png" alt="" width="23px" height="23px">Manzana N casa 1 b/galan</p>
                    <p><img src="img/social (3).png" alt="" width="23px" height="23px">+57 3142906070</p>
                    <p><img src="img/social (3).png" alt="" width="23px" height="23px">+57 3113006696</p>
                   
                </div>
                <div class="letra">
                    <h5>Enlaces Rápidos</h5>
                    <p>> Acerca De Nosotros</p>
                    <p>> Contáctenos</p>
                    <p>> Nuestros Servicios</p>
                    <p>>Terminos & Condiciones</p>
                    <p>>Soporte</p>
                </div>
                <div class="letra">
                    <h5>Regístrate</h5>
                    <p>Regístrate ahora y disfruta de beneficios exclusivos.</p>
                    <button><a class="dropdown-item" href="login/index.html">Registrarse</a></button>
                </div>
                
            </div>
        </div>
        <h6 class="titulo-final">&copy; Ibagué-Tolima, Bienvenidos</h6>
    </footer>



    <button id="scrollToTopBtn" title="Subir hacia arriba"><img src="img/flecha-arriba.png" alt="23px" height="23px" width=""></button>
     <script src="scripts.js"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>