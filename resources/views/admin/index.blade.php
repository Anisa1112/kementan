@extends('layouts.app')
@section('title', 'Admin Panel - Role Management')
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Role Management</h4>
                <p class="text-muted mb-0">Kelola permission dan akses data per sektor untuk setiap role</p>
            </div>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-x me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- ROLE MANAGEMENT -->
        @if(auth()->check() && auth()->user()->isSuperAdmin())

            <!-- Role Management Header Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-shield-lock ti-lg"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Pengaturan Permission & Akses Data</h5>
                            <p class="text-muted mb-0">Kelola permission umum dan akses data per sektor untuk setiap role pengguna</p>
                        </div>
                        <button type="button" class="btn btn-primary" id="saveBtn" onclick="savePermissions()">
                            <i class="ti ti-device-floppy me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Permissions Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tabel Permission</h5>
                    <small class="text-muted">Centang untuk memberikan akses permission kepada role</small>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 30%">Permission</th>
                                    <th class="text-center" style="width: 15%">Super Admin</th>
                                    <th class="text-center" style="width: 15%">Admin Pusdatin</th>
                                    <th class="text-center" style="width: 15%">Admin Eselon</th>
                                    <th class="text-center" style="width: 15%">User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $permissions = [
                                        // General Permissions
                                        ['name' => 'Kelola Komoditas', 'key' => 'manage_komoditas', 'desc' => 'Create, Read, Update, Delete komoditas', 'category' => 'general'],
                                        ['name' => 'Kelola PSP', 'key' => 'manage_psp', 'desc' => 'Create, Read, Update, Delete PSP', 'category' => 'general'],

                                        // Sector Komoditas Permissions
                                        ['name' => 'Akses Sektor Tanaman Pangan', 'key' => 'access_sector_pangan', 'desc' => 'Dapat melihat data komoditas tanaman pangan', 'category' => 'sector_komoditas', 'icon' => 'ti-grain', 'color' => 'warning'],
                                        ['name' => 'Akses Sektor Hortikultura', 'key' => 'access_sector_horti', 'desc' => 'Dapat melihat data komoditas hortikultura', 'category' => 'sector_komoditas', 'icon' => 'ti-leaf', 'color' => 'success'],
                                        ['name' => 'Akses Sektor Perkebunan', 'key' => 'access_sector_perkebunan', 'desc' => 'Dapat melihat data komoditas perkebunan', 'category' => 'sector_komoditas', 'icon' => 'ti-tree', 'color' => 'info'],
                                        ['name' => 'Akses Sektor Peternakan', 'key' => 'access_sector_peternakan', 'desc' => 'Dapat melihat data komoditas peternakan', 'category' => 'sector_komoditas', 'icon' => 'ti-pig', 'color' => 'danger'],

                                        // Sector PSP Permissions
                                        ['name' => 'Akses PSP Tanaman Pangan', 'key' => 'access_psp_pangan', 'desc' => 'Dapat melihat data PSP tanaman pangan', 'category' => 'sector_psp', 'icon' => 'ti-grain', 'color' => 'warning'],
                                        ['name' => 'Akses PSP Hortikultura', 'key' => 'access_psp_horti', 'desc' => 'Dapat melihat data PSP hortikultura', 'category' => 'sector_psp', 'icon' => 'ti-leaf', 'color' => 'success'],
                                        ['name' => 'Akses PSP Perkebunan', 'key' => 'access_psp_perkebunan', 'desc' => 'Dapat melihat data PSP perkebunan', 'category' => 'sector_psp', 'icon' => 'ti-tree', 'color' => 'info'],
                                        ['name' => 'Akses PSP Peternakan', 'key' => 'access_psp_peternakan', 'desc' => 'Dapat melihat data PSP peternakan', 'category' => 'sector_psp', 'icon' => 'ti-pig', 'color' => 'danger'],
                                    ];

                                    $roles = ['superadmin', 'admin_pusdatin', 'admin_eselon', 'user'];

                                    // Load saved permissions from storage or use defaults
                                    $savedPermissions = [];
                                    $permFile = storage_path('app/role_permissions.json');
                                    if (file_exists($permFile)) {
                                        $jsonContent = file_get_contents($permFile);
                                        $savedPermissions = json_decode($jsonContent, true) ?? [];
                                    }

                                    // Default permissions jika belum ada file ilham
                                    $defaultPermissions = [
                                        'superadmin' => [
                                            'manage_komoditas' => true,
                                            'manage_psp' => true,
                                            'access_sector_pangan' => true,
                                            'access_sector_horti' => true,
                                            'access_sector_perkebunan' => true,
                                            'access_sector_peternakan' => true,
                                            'access_psp_pangan' => true,
                                            'access_psp_horti' => true,
                                            'access_psp_perkebunan' => true,
                                            'access_psp_peternakan' => true,
                                        ],
                                        'admin_pusdatin' => [
                                            'manage_komoditas' => true,
                                            'manage_psp' => true,
                                            'access_sector_pangan' => true,
                                            'access_sector_horti' => true,
                                            'access_sector_perkebunan' => true,
                                            'access_sector_peternakan' => true,
                                            'access_psp_pangan' => true,
                                            'access_psp_horti' => true,
                                            'access_psp_perkebunan' => true,
                                            'access_psp_peternakan' => true,
                                        ],
                                        'admin_eselon' => [
                                            'manage_komoditas' => true,
                                            'manage_psp' => true,
                                            'access_sector_pangan' => true,
                                            'access_sector_horti' => true,
                                            'access_sector_perkebunan' => true,
                                            'access_sector_peternakan' => true,
                                            'access_psp_pangan' => true,
                                            'access_psp_horti' => true,
                                            'access_psp_perkebunan' => true,
                                            'access_psp_peternakan' => true,
                                        ],
                                        'user' => [
                                            'access_sector_pangan' => true,
                                            'access_sector_horti' => true,
                                        ],
                                    ];

                                    // Merge: gunakan saved jika ada, jika tidak gunakan default
                                    $currentPermissions = [];
                                    foreach ($roles as $role) {
                                        if (isset($savedPermissions[$role])) {
                                            $currentPermissions[$role] = $savedPermissions[$role];
                                        } else {
                                            $currentPermissions[$role] = $defaultPermissions[$role] ?? [];
                                        }
                                    }
                                @endphp

                                <!-- General Permissions -->
                                <tr class="table-secondary">
                                    <td colspan="5">
                                        <strong><i class="ti ti-settings me-2"></i>Permission Umum</strong>
                                    </td>
                                </tr>
                                @foreach($permissions as $permission)
                                    @if($permission['category'] == 'general')
                                    <tr>
                                        <td>
                                            <div>
                                                <strong>{{ $permission['name'] }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $permission['desc'] }}</small>
                                            </div>
                                        </td>
                                        @foreach($roles as $role)
                                            @php
                                                $rolePerms = $currentPermissions[$role] ?? [];
                                                // Check if permission is set and true
                                                $isChecked = isset($rolePerms[$permission['key']]) && $rolePerms[$permission['key']] === true;
                                            @endphp
                                            <td class="text-center">
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input
                                                        class="form-check-input permission-switch"
                                                        type="checkbox"
                                                        name="permissions[{{ $role }}][{{ $permission['key'] }}]"
                                                        id="perm_{{ str_replace(' ', '_', $role) }}_{{ $permission['key'] }}"
                                                        {{ $isChecked ? 'checked' : '' }}
                                                        {{ $role === 'superadmin' ? 'disabled' : '' }}
                                                    >
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endif
                                @endforeach

                                <!-- Sector Komoditas Permissions -->
                                <tr class="table-secondary">
                                    <td colspan="5">
                                        <strong><i class="ti ti-plant me-2"></i>Akses Data Komoditas Per Sektor</strong>
                                        <br>
                                        <small class="text-muted">Atur sektor mana saja yang dapat diakses oleh setiap role</small>
                                    </td>
                                </tr>
                                @foreach($permissions as $permission)

                                    @if($permission['category'] == 'sector_komoditas')
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <span class="avatar-initial rounded bg-label-{{ $permission['color'] ?? 'secondary' }}">
                                                        <i class="ti {{ $permission['icon'] ?? 'ti-database' }}"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <strong>{{ $permission['name'] }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $permission['desc'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        @foreach($roles as $role)
                                            @php
                                                $rolePerms = $currentPermissions[$role] ?? [];
                                                //dd($roles);
                                                $isChecked = false;

                                                if (is_array($rolePerms) && isset($rolePerms[$permission['key']])) {
                                                    // Cek apakah value-nya true (bukan string "true")
                                                    $isChecked = $rolePerms[$permission['key']] === true;
                                                }
                                                                                    @endphp
                                            <td class="text-center">
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input
                                                        class="form-check-input permission-switch"
                                                        type="checkbox"
                                                        name="permissions[{{ $role }}][{{ $permission['key'] }}]"
                                                        id="perm_{{ str_replace(' ', '_', $role) }}_{{ $permission['key'] }}"
                                                        {{ $isChecked ? 'checked' : '' }}
                                                        {{ $role === 'superadmin' ? 'disabled' : '' }}
                                                    >
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endif
                                @endforeach

                                <!-- Sector PSP Permissions -->
                                <tr class="table-secondary">
                                    <td colspan="5">
                                        <strong><i class="ti ti-chart-line me-2"></i>Akses Data PSP Per Sektor</strong>
                                        <br>
                                        <small class="text-muted">Atur akses data PSP per sektor untuk setiap role</small>
                                    </td>
                                </tr>
                                @foreach($permissions as $permission)
                                    @if($permission['category'] == 'sector_psp')
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <span class="avatar-initial rounded bg-label-{{ $permission['color'] ?? 'secondary' }}">
                                                        <i class="ti {{ $permission['icon'] ?? 'ti-database' }}"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <strong>{{ $permission['name'] }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $permission['desc'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        @foreach($roles as $role)
                                            @php
                                                $rolePerms = $currentPermissions[$role] ?? [];
                                                $isChecked = false;

                                                if (is_array($rolePerms) && isset($rolePerms[$permission['key']])) {
                                                    // Cek apakah value-nya true (bukan string "true")
                                                    $isChecked = $rolePerms[$permission['key']] === true;
                                                }
                                            @endphp
                                            <td class="text-center">
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input
                                                        class="form-check-input permission-switch"
                                                        type="checkbox"
                                                        name="permissions[{{ $role }}][{{ $permission['key'] }}]"
                                                        id="perm_{{ str_replace(' ', '_', $role) }}_{{ $permission['key'] }}"
                                                        {{ $isChecked ? 'checked' : '' }}
                                                        {{ $role === 'superadmin' ? 'disabled' : '' }}
                                                    >
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info mt-3" role="alert">
                        <i class="ti ti-info-circle me-2"></i>
                        <strong>Catatan:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Super Admin memiliki semua permission secara default dan tidak dapat diubah</li>
                            <li>Akses per sektor memungkinkan kontrol granular terhadap data yang dapat dilihat</li>
                            <li>User hanya dapat melihat data sektor yang diizinkan oleh Super Admin</li>
                        </ul>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="ti ti-clock me-1"></i>Terakhir diupdate: {{ now()->format('d M Y, H:i') }} WIB
                        </small>
                        <button type="button" class="btn btn-primary" onclick="savePermissions()">
                            <i class="ti ti-device-floppy me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Role Statistics -->
            <div class="row g-4 mt-2">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar avatar-lg mx-auto mb-3">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="ti ti-crown ti-lg"></i>
                                </span>
                            </div>
                            <h6 class="mb-2">Super Admin</h6>
                            <p class="text-muted small mb-0">Full Access</p>
                            <h4 class="text-danger mt-2">{{ $totalSuperAdmin ?? 1 }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar avatar-lg mx-auto mb-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="ti ti-building ti-lg"></i>
                                </span>
                            </div>
                            <h6 class="mb-2">Admin Pusdatin</h6>
                            <p class="text-muted small mb-0">Manage & Approve</p>
                            <h4 class="text-primary mt-2">{{ $totalAdminPusdatin ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar avatar-lg mx-auto mb-3">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="ti ti-user-shield ti-lg"></i>
                                </span>
                            </div>
                            <h6 class="mb-2">Admin Eselon</h6>
                            <p class="text-muted small mb-0">Manage Content</p>
                            <h4 class="text-warning mt-2">{{ $totalAdminEselon ?? 0 }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar avatar-lg mx-auto mb-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="ti ti-user ti-lg"></i>
                                </span>
                            </div>
                            <h6 class="mb-2">User</h6>
                            <p class="text-muted small mb-0">View Only</p>
                            <h4 class="text-info mt-2">{{ $totalUser ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>

        @endif
        <!-- END ROLE MANAGEMENT -->

    </div>
</div>

<!-- JavaScript -->
<script>
function savePermissions() {
    const btn = document.getElementById('saveBtn') || event.target;
    const originalText = btn.innerHTML;

    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = '<i class="ti ti-loader ti-spin me-1"></i>Menyimpan...';

    try {
        // Collect ALL permission data (including unchecked)
        const permissions = {};
        const allCheckboxes = document.querySelectorAll('.permission-switch');

        allCheckboxes.forEach(input => {
            const match = input.name.match(/permissions\[(.*?)\]\[(.*?)\]/);
            if (match) {
                const role = match[1];
                const permission = match[2];

                if (!permissions[role]) {
                    permissions[role] = {};
                }

                // Set true/false berdasarkan checked state
                // Untuk Super Admin, selalu true (meski disabled)
                if (role === 'superadmin') {
                    permissions[role][permission] = true;
                } else {
                    permissions[role][permission] = input.checked;
                }
            }
        });

        console.log('Permissions to save:', permissions);

        // Validate data
        if (Object.keys(permissions).length === 0) {
            throw new Error('Tidak ada data permission yang akan disimpan');
        }

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        // Send to server
        fetch('{{ url("/roles/update-permissions") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ permissions: permissions })
        })
        .then(response => {
            console.log('Response status:', response.status);

            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Error response:', text);
                    throw new Error(`Server error (${response.status}): ${text.substring(0, 100)}`);
                });
            }

            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);

            // Re-enable button
            btn.disabled = false;
            btn.innerHTML = originalText;

            if (data.success) {
                showAlert('success', data.message || 'Permission berhasil disimpan!');

                // Reload page after 2 seconds to reflect changes
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showAlert('danger', data.message || 'Gagal menyimpan permission');
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Re-enable button
            btn.disabled = false;
            btn.innerHTML = originalText;

            showAlert('danger', error.message || 'Terjadi kesalahan saat menyimpan permission');
        });

    } catch (error) {
        console.error('Client error:', error);

        // Re-enable button
        btn.disabled = false;
        btn.innerHTML = originalText;

        showAlert('danger', error.message || 'Terjadi kesalahan pada sistem');
    }
}

function showAlert(type, message) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert:not(.alert-info)');
    existingAlerts.forEach(alert => alert.remove());

    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="ti ti-${type === 'success' ? 'check' : 'x'} me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    // Insert at top of content
    const contentWrapper = document.querySelector('.container-xxl');
    const firstCard = contentWrapper.querySelector('.card');
    if (firstCard) {
        contentWrapper.insertBefore(alertDiv, firstCard);
    } else {
        contentWrapper.insertBefore(alertDiv, contentWrapper.firstChild);
    }

    // Auto hide after 5 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Page loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Role management page loaded successfully');
});
</script>

@endsection
