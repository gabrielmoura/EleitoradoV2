<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div>
                    <!-- Sidenav Heading (Addons)-->
                    <div class="sidenav-menu-heading">Home</div>
                    <!-- Sidenav Link (Charts)-->
                    <a class="nav-link {{request()->routeIs('*.dashboard')?'active':null}}"
                       href="{{route('dashboard')}}">
                        <div class="nav-link-icon"><i class="fa fa-envelope-o"></i></div>
                        Home
                    </a>

                    <a class="nav-link {{request()->routeIs('dash.person*')?'active':null}}"
                       href="{{route('dash.person.index')}}">
                        <div class="nav-link-icon"><i class="fa fa-envelope-o"></i></div>
                        Pessoas
                    </a>
                    <a class="nav-link {{request()->routeIs('dash.group.*')?'active':null}}"
                       href="{{route('dash.group.index')}}">
                        <div class="nav-link-icon"><i class="fa fa-envelope-o"></i></div>
                        Grupos
                    </a>
                    <a class="nav-link {{request()->routeIs('dash.event.*')?'active':null}}"
                       href="{{route('dash.event.index')}}">
                        <div class="nav-link-icon"><i class="fa fa-envelope-o"></i></div>
                        Eventos
                    </a>
                    <a class="nav-link {{request()->routeIs('dash.demand.*')?'active':null}}"
                       href="{{route('dash.demand.index')}}">
                        <div class="nav-link-icon"><i class="fa fa-envelope-o"></i></div>
                        Demandas
                    </a>
                    <a class="nav-link {{request()->routeIs('dash.demandType.*')?'active':null}}"
                       href="{{route('dash.demandType.index')}}">
                        <div class="nav-link-icon"><i class="fa fa-envelope-o"></i></div>
                        Tipos de Demanda
                    </a>
                    @cannot('user')
                        <div class="sidenav-menu-heading">Administrativo</div>
                        <a class="nav-link" href="#">
                            <div class="nav-link-icon">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            Usuários
                        </a>
                    @endcannot
                </div>
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title">{{session()->get('user.name')}}</div>
            </div>
        </div>
    </nav>
</div>
