<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ Auth::User()->name }}</a>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-header">PENGATURAN</li>
            <x-side-bar-item caption="Pelayanan Lab" url="{{ url('/pelayanan_lab') }}" fa-icon="fa-suitcase" />
            <x-side-bar-item caption="Mapping Kegiatan" url="{{ url('/kegiatan') }}" fa-icon="fa-suitcase" />
            <x-side-bar-item caption="Penanda Tangan Hasil" url="{{ url('/penanda_tangan_hasil') }}" fa-icon="fa-suitcase" />
            <x-side-bar-item caption="Pengguna" url="{{ url('/master_data/usersatker') }}" fa-icon="fa-suitcase" />

            <li class="nav-header">PELAYANAN LAB</li>
            <x-side-bar-item caption="Antrian Lab" url="{{ url('/antrian_lab') }}" fa-icon="fa-suitcase" />
            <x-side-bar-item caption="Antrian Lab (Masuk)" url="{{ url('/antrian_lab/antrian_masuk') }}" fa-icon="fa-suitcase" />
            <x-side-bar-item caption="Antrian Lab (Hasil)" url="{{ url('/antrian_lab/antrian_selesai_periksa') }}" fa-icon="fa-suitcase" />
            <x-side-bar-item caption="Antrian Lab (Selesai)" url="{{ url('/antrian_lab/antrian_selesai_hasil') }}" fa-icon="fa-suitcase" />
            <x-side-bar-item caption="Antrian Lab (Batal)" url="{{ url('/antrian_lab/antrian_batal') }}" fa-icon="fa-suitcase" />

            <li class="nav-header">USER</li>
            <x-side-bar-item caption="Log Out" url="{{ url('/logout') }}" fa-icon="fa-lock-open" />
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
    <br />
</div>
<!-- /.sidebar -->