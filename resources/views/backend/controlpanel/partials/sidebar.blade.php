<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        {{-- <a href="{{ route('backend.superadmin.dashboard') }}" class="brand-link"> --}}

        <!--begin::Brand Image-->
        <img src="{{ asset('admin/dist/assets/img/itmediumLogoRed.png') }}" alt="AdminLTE Logo"
            class="brand-image opacity-75 shadow" height="33px" />
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">बालगंगा ई -पुस्तकालय </span>
        <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="{{ route('backend.controlpanel.superadmin.dashboard') }}" class="nav-link active">
                        <i class="nav-icon bi bi-bank2"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>

                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            Users Management
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.users.index') }}"
                                class="nav-link {{ request()->routeIs('backend.users.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-file-person-fill"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.roles.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-wrench-adjustable-circle"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.permissions.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-file-lock2-fill"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>




                {{-- Books Management Starts --}}
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon bi bi-book"></i>
                        <p>
                            Books Management
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.books.index') }}"
                                class="nav-link {{ request()->routeIs('backend.users.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-book-fill"></i>
                                <p>Books</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.categories.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list-ol"></i>
                                <p>Categories </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.authors.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-person-fill-check"></i>
                                <p>Authors </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.publishers.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-printer-fill"></i>
                                <p>Publishers </p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Books Management Ends --}}

                {{-- Circulation Starts --}}

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon bi bi-distribute-horizontal"></i>
                        <p>
                            Circulation
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.book-issues.index') }}"
                                class="nav-link {{ request()->routeIs('backend.users.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-journal-minus"></i>
                                <p>Issue Books</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.book-returns.index') }}" class="nav-link">
                                <i class="nav-icon bi-arrow-return-left"></i>
                                <p>Return Books </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('backend.permissions.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-arrow-up-right-square-fill"></i>
                                <p>Renewals </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.permissions.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-currency-rupee"></i>
                                <p>Overdue & Fines </p>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                {{-- Circulation Ends --}}
                {{-- Members Starts --}}
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon bi bi-people"></i>
                        <p>
                            Members
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('backend.students.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-person-fill-add"></i>
                                <p>Students/Members </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.permissions.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-person-add"></i>
                                <p> Membership Status </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.library-cards.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-person-add"></i>
                                <p> Library Card </p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Members Ends --}}

                {{-- Digital Library Starts --}}
                    {{-- <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon bi bi-globe"></i>
                            <p>
                                Digital Library
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('backend.users.index') }}"
                                    class="nav-link {{ request()->routeIs('backend.users.*') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-book-half"></i>
                                    <p>e-Books</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('backend.roles.index') }}" class="nav-link">
                                    <i class="nav-icon bi bi-journal-bookmark-fill"></i>
                                    <p>Journals </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('backend.permissions.index') }}" class="nav-link">
                                    <i class="nav-icon bi bi-box-arrow-up-right"></i>
                                    <p> External Resources </p>
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                {{-- Digital Library Ends --}}

                {{-- Inventory Starts --}}
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon bi bi-bookshelf"></i>
                        <p>
                            Inventory
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.inventory-categories.index') }}"
                                class="nav-link {{ request()->routeIs('backend.users.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-database-fill"></i>
                                <p>Inventory Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.stocks.index') }}"
                                class="nav-link {{ request()->routeIs('backend.users.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-database-fill"></i>
                                <p>Stock</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.roles.index') }}" class="nav-link">
                                <i class="nav-icon bi bi bi-0-circle"></i>
                                <p>Lost & Damage </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.purchase-requests.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-cart-plus"></i>
                                <p> Purchase Requests </p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Inventory Ends --}}


                {{-- Reports Starts --}}
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon bi bi-clipboard-data"></i>
                        <p>
                            Reports & Analytics
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('backend.users.index') }}"
                                class="nav-link {{ request()->routeIs('backend.users.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-bookmark-dash-fill"></i>
                                <p>Borrowing Stats</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.roles.index') }}" class="nav-link">
                                <i class="nav-iconbi bi-journal-album"></i>
                                <p>Popular Books </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.permissions.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-collection-fill"></i>
                                <p>Fines Collected </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.permissions.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-person-walking"></i>
                                <p>Active Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- Reports Ends --}}




                {{-- <li class="nav-item">
                    <a href="{{ route('backend.visitors.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-person-lines-fill"></i>
                        <p>Visitors</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('backend.enquiries.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-person-lines-fill"></i>
                        <p>Enquiry</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-pencil-square"></i>
                        <p>Blogs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-repeat"></i>
                        <p>Follow Ups</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-palette"></i>
                        <p>Theme Setting</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-question-circle-fill"></i>
                        <p>FAQ</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-patch-check-fill"></i>
                        <p>License</p>
                    </a>
                </li>

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
