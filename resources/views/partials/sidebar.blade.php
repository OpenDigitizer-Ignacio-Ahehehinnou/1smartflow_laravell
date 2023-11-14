<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class='sidebar-brand' href='index.html'>
            <span class="sidebar-brand-text align-middle">
                Smartflow
            </span>

        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Documents
            </li>

            <li class="sidebar-item active">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle"
                        style="color: #fff">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#approvals" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="check"></i> <span class="align-middle"
                        style="color: #fff">Approbations -</span>
                </a>
                <ul id="approvals" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('approval.pending', ['page' => 0]) }}">En attente</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('approval.approved', ['page' => 0]) }}">Approuvés</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('approval.rejected', ['page' => 0]) }}">Rejetés</a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#documents" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="file-text"></i> <span class="align-middle"
                        style="color: #fff">Documents -</span>
                </a>
                <ul id="documents" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('document.created', ['page' => 0]) }}">Crées</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('document.initiated', ['page' => 0]) }}">Initiés</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('document.validated', ['page' => 0]) }}">Validés</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('document.rejected', ['page' => 0]) }}">Rejetés</a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a data-bs-target="#forms" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="file"></i> <span class="align-middle"
                        style="color: #fff">Formulaires -</span>
                </a>
                <ul id="forms" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('form.myforms', ['page' => 0]) }}">Mes formulaires</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('form.models', ['page' => 0]) }}">Modèles</a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('user.index', ['page' => 0]) }}">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle"
                        style="color: #fff">Utilisateurs</span>
                </a>
            </li>

            <li class="sidebar-header">
                Administration
            </li>


            <li class="sidebar-item">
                <a data-bs-target="#entreprise" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle"
                        style="color: #fff">Entreprise -</span>
                </a>
                <ul id="entreprise" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('enterprise.index') }}">Détails</a></li>
                    <li class="sidebar-item"><a class='sidebar-link' style="color: #fff"
                            href="{{ route('firm.index', ['page' => 0]) }}">Filiales</a></li>
                </ul>
            </li>





            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('function.index', ['page' => 0]) }}">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle"
                        style="color: #fff">Fonctions</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('role.index') }}">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle"
                        style="color: #fff">Rôles</span>
                </a>
            </li>
        </ul>


    </div>
</nav>
