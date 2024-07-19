<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">เมนู</li>
        <li class="sidebar-item ">
            <a href="<?= $uri; ?>home" class='sidebar-link'>
                <i class="bi bi-check2-circle"></i>
                <span>หน้าหลัก</span>
            </a>
        </li>

        <li class="sidebar-item ">
            <a href="<?= $uri; ?>database" class='sidebar-link'>
                <i class="bi bi-check2-circle"></i>
                <span>database
                    <span class="badge bg-danger">
                        2
                    </span>
                </span>
            </a>
        </li>
        <li class="sidebar-item ">
            <a href="<?= $uri; ?>datatable" class='sidebar-link'>
                <i class="bi bi-check2-circle"></i>
                <span>datatable
                    <span class="badge bg-danger">
                        3
                    </span>
                </span>
            </a>
        </li>
        <li class="sidebar-item ">
            <a href="<?= $uri; ?>calendar" class='sidebar-link'>
                <i class="bi bi-hourglass"></i>
                <span>calendar
                    <span class="badge bg-danger">
                        1
                    </span>
                </span>
            </a>
        </li>
        <li class="sidebar-item ">
            <a href="<?= $uri; ?>chart" class='sidebar-link'>
                <i class="bi bi-check"></i>
                <span>chart</span>
            </a>
        </li>

        <li class="sidebar-item ">
            <a href="<?= $uri; ?>administrator" class='sidebar-link'>
                <i class="bi bi-r-circle"></i>
                <span>administrator</span>
            </a>
        </li>
        <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-gear"></i>
                <span>ตั้งค่าระบบ</span>
            </a>
            <ul class="submenu ">
                <li class="submenu-item ">
                    <a href="<?= $uri; ?>base1">base1</a>
                </li>
                <li class="submenu-item ">
                    <a href="<?= $uri; ?>base2">base2</a>
                </li>
                <li class="submenu-item ">
                    <a href="<?= $uri; ?>base3">base3</a>
                </li>
                <li class="submenu-item ">
                    <a href="<?= $uri; ?>base4">base4</a>
                </li>
            </ul>
        </li>

        <li class="sidebar-item">
            <a href="<?= $uri; ?>log-action" class='sidebar-link'>
                <i class="bi bi-card-checklist"></i>
                <span>Log Action</span>
            </a>
        </li>

        <!-- -------------------------------------------- -->
        <li class="sidebar-item">
            <a href="<?= $uri; ?>logout" class='sidebar-link'>
                <i class="bi bi-box-arrow-left"></i>
                <span>ออกจากระบบ</span>
            </a>
        </li>
    </ul>
</div>