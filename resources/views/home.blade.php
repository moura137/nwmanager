@extends('app')

@section('content')
<div id="wrapper" ng-show="AuthUser">
    <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">

                    <a data-toggle="dropdown" class="dropdown-toggle">
                        <span class="clear">
                            <span class="block m-t-xs"> <strong class="font-bold">[[ AuthUser.name ]]</strong> <b class="caret"></b></span>
                            <span class="text-muted text-xs block">[[ AuthUser.email ]]</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="/login">Sair</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    NW
                </div>
            </li>
            <li>
                <a ng-href="#/client"><i class="fa fa-group"></i> <span class="nav-label">Clientes</span></a>
            </li>
            <li>
                <a ng-href="#/user"><i class="fa fa-user"></i> <span class="nav-label">Usuários</span></a>
            </li>
            <li>
                <a ng-href="#/project"><i class="fa fa-briefcase"></i> <span class="nav-label">Projetos</span></a>
            </li>
        </ul>
    </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        </div>

        <div id="content" ng-view ng-hide="isRefreshingToken"></div>

        <div class="footer">
            <div>
                <strong>Copyright</strong> {{ date('Y') }}
            </div>
        </div>
    </div>
</div>
@endsection