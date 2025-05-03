<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">

              <div class="logo-login">
                  <h3>ML</h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{ asset('images/default-user.png') }}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Hola!</span>
                <h2>{{ Auth::user()->name }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menú</h3>
                <ul class="nav side-menu">
                  
                  <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i> Home </a></li>
                  
                  <li><a><i class="fa fa-file-text-o" aria-hidden="true"></i> Órdenes <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/admin/add-orden') }}">Nueva orden</a></li>
                      <li><a href="{{ url('/admin/view-ordenes') }}">Ver órdenes</a></li>
                    </ul>
                  </li>
                  
                  <li><a><i class="fa fa-credit-card" aria-hidden="true"></i> Pagos <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/admin/add-pago') }}">Nuevo pago</a></li>
                      <li><a href="{{ url('/admin/view-pagos') }}">Ver pagos</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-users" aria-hidden="true"></i> Clientes <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/admin/add-cliente') }}">Nuevo cliente</a></li>
                      <li><a href="{{ url('/admin/view-clientes') }}">Ver clientes</a></li>
                    </ul>
                  </li>

                  <li><a href="{{ url('/admin/view-frases') }}"><i class="fa fa-comment" aria-hidden="true"></i> Frases</a></li>

                  <li><a><i class="fa fa-list" aria-hidden="true"></i> Tipos <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/admin/add-tipo') }}">Nuevo tipo</a></li>
                      <li><a href="{{ url('/admin/view-tipos') }}">Ver tipos</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-tags" aria-hidden="true"></i> Temas <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/admin/add-tema') }}">Nuevo tema</a></li>
                      <li><a href="{{ url('/admin/view-temas') }}">Ver temas</a></li>
                    </ul>
                  </li>
                  
                  <li><a><i class="fa fa-file-text" aria-hidden="true"></i> Blog <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/admin/add-post') }}">Nuevo post</a></li>
                      <li><a href="{{ url('/admin/view-posts') }}">Ver posts</a></li>
                    </ul>
                  </li>

                  {{--<li><a href="{{ url('/admin/edit-config/1') }}"><i class="fa fa-gear"></i> Configuración</a></li>--}}                  
                  
                  <li><a><i class="fa fa-users"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/admin/agregar-usuario') }}">Nuevo Usuario</a></li>
                      <li><a href="{{ url('/admin/ver-usuarios') }}">Ver Usuarios</a></li>
                    </ul>
                  </li>

                </ul>
              </div>

            </div> 
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ url('/logout') }}" style="width: 100%;">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

