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
                        <div class="nav-link-icon">
                            <i class="fad fa-home fa-lg"></i>
                        </div>
                        Home
                    </a>

                    @role('admin')
                    <a class="nav-link {{request()->routeIs('admin.plan.*')?'active':null}}"
                       href="{{route('admin.plan.index')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-money-check-edit fa-lg"></i>
                        </div>
                        Planos
                    </a>
                    <a class="nav-link {{request()->routeIs('admin.company.*')?'active':null}}"
                       href="{{route('admin.company.index')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-industry-alt fa-lg"></i>
                        </div>
                        Empresas
                    </a>
                    <a class="nav-link {{request()->routeIs('admin.user.*')?'active':null}}"
                       href="{{route('admin.user.index')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-users fa-lg"></i>
                        </div>
                        Usuários
                    </a>
                    @endrole

                    @role(['manager','user'])

                    <a class="nav-link {{request()->routeIs('dash.person*')?'active':null}}"
                       href="{{route('dash.person.index')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-male fa-lg"></i>
                        </div>
                        Pessoas
                    </a>
                    <a class="nav-link {{request()->routeIs('dash.group.*')?'active':null}}"
                       href="{{route('dash.group.index')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-users fa-lg"
                            ></i>
                        </div>
                        Grupos
                    </a>
                    <a class="nav-link {{request()->routeIs('dash.event.*')?'active':null}}"
                       href="{{route('dash.event.index')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-calendar-check fa-lg"
                            ></i>
                        </div>
                        Eventos
                    </a>

                    @feature('App\Features\Appointment')
                    <a class="nav-link {{request()->routeIs('dash.appointment.*')?'active':null}}"
                       href="{{route('dash.appointment.index')}}">
                        <div class="nav-link-icon">
                            <i class="me-1 fad fa-calendar"></i>
                        </div>
                        Agendamentos
                    </a>
                    @endfeature

                    <a class="nav-link {{request()->routeIs('dash.demand.*')?'active':null}}"
                       href="{{route('dash.demand.index')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-hand-holding-magic fa-lg"
                            ></i>
                        </div>
                        Demandas
                    </a>
                    <a class="nav-link {{request()->routeIs('dash.demandType.*')?'active':null}}"
                       href="{{route('dash.demandType.index')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-hand-holding-box fa-lg"></i>
                        </div>
                        Tipos de Demanda
                    </a>

                    <a class="nav-link {{request()->routeIs('dash.birthdays')?'active':null}}"
                       href="{{route('dash.birthdays')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-birthday-cake fa-lg"></i>
                        </div>
                        Aniversariantes
                    </a>
                    @endrole

                    @role('manager')
                    <div class="sidenav-menu-heading">Administrativo</div>
                    <a class="nav-link {{request()->routeIs('dash.user.*')?'active':null}}"
                       href="{{route('dash.user.index')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-user-shield fa-lg"></i>
                        </div>
                        Usuários
                    </a>
                    <a class="nav-link {{request()->routeIs('dash.company.*')?'active':null}}"
                       href="{{route('dash.company.index')}}">
                        <div class="nav-link-icon">
                            <i class="fad fa-industry-alt fa-lg"></i>
                        </div>
                        Empresa
                    </a>
                    @endrole
                    @can('invoicing')
                        <div class="sidenav-menu-heading">Pagamentos</div>
                        <a class="nav-link {{request()->routeIs('dash.invoicing.*')?'active':null}}"
                           href="{{route('dash.payment.index')}}">
                            <div class="nav-link-icon">
                                <i class="fad fa-file-invoice-dollar fa-lg"></i>
                            </div>
                            Faturamento
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">logado como:</div>
                <div class="sidenav-footer-title">{{session()->get('user.name')}}</div>
            </div>
        </div>
    </nav>
</div>
