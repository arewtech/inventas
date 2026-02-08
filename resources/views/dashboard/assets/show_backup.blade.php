@extends('layouts.app', ['title' => 'Detail Aset'])

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Detail Aset: {{ $groupedAsset->name }}</h5>
                    <a href="{{ route('assets.index') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left fs-4"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="alert alert-info">
                            <strong>Info!</strong>
                            Semua data Aset yang ditambahkan pada inventaris berasal dari kepala yayasan.
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-light" width="200" style="vertical-align: middle;">Gambar</th>
                                    <td>
                                        @if ($groupedAsset->image)
                                            <img src="{{ asset('storage/' . $groupedAsset->image) }}" alt="{{ $groupedAsset->name }}"
                                                class="img-fluid rounded" style="max-width: 180px;">
                                        @else
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="ti ti-photo-off text-muted fs-6"></i>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nomor Aset</th>
                                    <td>
                                        <b>Grup: {{ $groupedAsset->name }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama Aset</th>
                                    <td>{{ $groupedAsset->name }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kategori</th>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">
                                            {{ $groupedAsset->category->name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Deskripsi</th>
                                    <td>{{ $groupedAsset->description ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Total Aset</th>
                                    <td>
                                        <span class="badge bg-primary">{{ $groupedAsset->total_assets }} Unit</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kondisi Baik</th>
                                    <td>
                                        <span class="badge bg-success">{{ $groupedAsset->total_baik }} Unit</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kondisi Rusak</th>
                                    <td>
                                        <span class="badge bg-danger">{{ $groupedAsset->total_rusak }} Unit</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dalam Perbaikan</th>
                                    <td>
                                        <span class="badge bg-warning">{{ $groupedAsset->total_perbaikan }} Unit</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Lokasi</th>
                                    <td>{{ $groupedAsset->location->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Informasi Tambahan</th>
                                    <td>{{ $groupedAsset->additional_info ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Penanggung Jawab</th>
                                    <td>{{ $groupedAsset->location->responsible_name ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Telepon Penanggung Jawab</th>
                                    <td>{{ $groupedAsset->location->responsible_phone ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dibuat Pada</th>
                                    <td>{{ \Carbon\Carbon::parse($groupedAsset->created_at)->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title text-white mb-0">QR Code</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="border p-3 mb-3 d-flex justify-content-center">
                                    <div id="qrcode"></div>
                                </div>
                                <p class="mb-2">Scan QR code untuk melihat informasi aset.</p>
                                <div class="d-grid gap-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm" id="btnPrint">
                                        <i class="ti ti-printer me-1"></i> Cetak QR Code
                                    </a>
                                    <a href="#" class="btn btn-outline-dark btn-sm" id="btnDownload">
                                        <i class="ti ti-download me-1"></i> Unduh QR Code
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Individual Assets List removed Damaged Assets Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-danger">
                                <div class="card-header bg-danger-subtle">
                                    <h5 class="card-title mb-0 text-danger">
                                        <i class="ti ti-alert-circle me-2"></i>Aset Rusak
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th width="50">No</th>
                                                    <th>Nomor Aset</th>
                                                    <th>Jumlah Rusak</th>
                                                    <th>Deskripsi Kerusakan</th>
                                                    <th>Tanggal Rusak</th>
                                                    <th width="200">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($groupedAsset->damagedAssets as $damaged)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <code>{{ $damaged->asset_number }}</code>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge bg-danger-subtle text-danger">{{ $damaged->quantity }}</span>
                                                        </td>
                                                        <td>{{ $damaged->description ?? '-' }}</td>
                                                        <td>{{ $damaged->created_at->format('d/m/Y H:i') }}</td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <form
                                                                    action="{{ route('assets.restore-damaged', $damaged->asset_number) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Yakin ingin memulihkan aset ini ke kondisi baik?')">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-success"
                                                                        title="Pulihkan ke Baik">
                                                                        <i class="ti ti-refresh"></i>
                                                                    </button>
                                                                </form>
                                                                <form
                                                                    action="{{ route('assets.destroy-damaged', $damaged->asset_number) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Yakin ingin menghapus aset rusak ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                                        title="Hapus Permanen">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="bg-light">
                                                <tr>
                                                    <td colspan="2" class="text-end"><strong>Total Rusak:</strong></td>
                                                    <td colspan="4">
                                                        <span
                                                            class="badge bg-danger fs-4">{{ $groupedAsset->total_damaged_quantity }}</span>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons removed -->

                <!-- QR Testing Section removed -->
                                                <button class="btn btn-outline-dark" type="button" id="copyQrUrl">
                                                    <i class="ti ti-copy"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">URL yang dienkode dalam QR code</small>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status QR Code:</label>
                                            <div id="qrStatus" class="alert alert-info">
                                                Klik tombol "Test QR" untuk memverifikasi bahwa QR code dapat diakses
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-primary" id="testQrBtn">
                                                <i class="ti ti-brand-telegram me-1"></i> Test QR
                                            </button>
                                            <a href="{{ $asset->qr_code }}" target="_blank"
                                                class="btn btn-outline-dark">
                                                <i class="ti ti-external-link me-1"></i> Buka di Tab Baru
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h6 class="mb-0">Hasil Test</h6>
                                            </div>
                                            <div class="card-body">
                                                <div id="testResult" class="p-3 border rounded bg-light"
                                                    style="min-height: 200px">
                                                    <p class="text-center text-muted">Hasil test akan muncul di sini</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/qrcode.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Generate QR code using qrcode.min.js
            const qrcode = new QRCode(document.getElementById('qrcode'), {
                text: "{{ $groupedAsset->qr_code ?? url('/') }}",
                width: 230,
                height: 230,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            initQRCodePrinting();
            initQRCodeDownload();
            initQRCodeTesting();
        });

        function initQRCodePrinting() {
            const btnPrint = document.getElementById('btnPrint');

            btnPrint.addEventListener('click', (e) => {
                e.preventDefault();

                const assetName = "{{ $groupedAsset->name }}";

                // Create the URL for the print page (not available for grouped assets)
                const printUrl = `#`;

                // Open in a new tab
                const printTab = window.open(printUrl, '_blank');

                // Focus on the new tab (helps with some browsers)
                if (printTab) {
                    printTab.focus();
                }
            });
        }

        function initQRCodeDownload() {
            const btnDownload = document.getElementById('btnDownload');

            btnDownload.addEventListener('click', (e) => {
                e.preventDefault();

                // Get canvas or image element from QR code
                const qrcodeElement = document.getElementById('qrcode');
                const canvas = qrcodeElement.querySelector('canvas');
                const img = qrcodeElement.querySelector('img');

                let downloadCanvas;

                if (canvas) {
                    // If QR code is rendered as canvas, use it directly
                    downloadCanvas = canvas;
                } else if (img) {
                    // If QR code is rendered as image, convert to canvas
                    downloadCanvas = document.createElement('canvas');
                    const ctx = downloadCanvas.getContext('2d');
                    downloadCanvas.width = img.width;
                    downloadCanvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
                }

                if (downloadCanvas) {
                    // Create a new canvas with padding and white background
                    const finalCanvas = document.createElement('canvas');
                    const ctx = finalCanvas.getContext('2d');
                    const padding = 50;

                    finalCanvas.width = downloadCanvas.width + (padding * 2);
                    finalCanvas.height = downloadCanvas.height + (padding * 2);

                    // Fill with white background
                    ctx.fillStyle = 'white';
                    ctx.fillRect(0, 0, finalCanvas.width, finalCanvas.height);

                    // Draw QR code in center
                    ctx.drawImage(downloadCanvas, padding, padding);

                    // Convert to JPG and download
                    const jpgUrl = finalCanvas.toDataURL('image/jpeg', 0.95);
                    const downloadLink = document.createElement('a');
                    downloadLink.href = jpgUrl;
                    const formatNameSlug = "{{ $groupedAsset->name }}".toLowerCase().replace(/ /g, '-').replace(
                        /[^\w-]+/g, '');
                    downloadLink.download = 'qrcode-' + formatNameSlug + '.jpg';
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                }
            });
        }

        function initQRCodeTesting() {
            const copyQrUrlBtn = document.getElementById('copyQrUrl');
            const testQrBtn = document.getElementById('testQrBtn');

            // Copy QR URL to clipboard
            copyQrUrlBtn.addEventListener('click', () => {
                const qrUrl = document.getElementById('qrUrl');
                qrUrl.select();
                document.execCommand('copy');
                alert('URL berhasil disalin ke clipboard');
            });

            // Test QR code accessibility
            testQrBtn.addEventListener('click', () => {
                const qrStatus = document.getElementById('qrStatus');
                const testResult = document.getElementById('testResult');
                const qrUrl = document.getElementById('qrUrl').value;

                // Display loading state
                showLoadingState(qrStatus, testResult);

                // Test URL connectivity
                testQRCodeUrl(qrUrl, qrStatus, testResult);
            });
        }

        function showLoadingState(statusElement, resultElement) {
            statusElement.className = 'alert alert-warning';
            statusElement.innerHTML = '<i class="ti ti-loader animate-spin me-1"></i> Sedang menguji QR code...';

            resultElement.innerHTML =
                '<p class="text-center"><i class="ti ti-loader animate-spin"></i> Loading...</p>';
        }

        function testQRCodeUrl(url, statusElement, resultElement) {
            fetch(url, {
                    method: 'HEAD',
                    mode: 'no-cors'
                })
                .then(() => {
                    // Success response
                    statusElement.className = 'alert alert-success';
                    statusElement.innerHTML = '<i class="ti ti-check me-1"></i> QR code dapat diakses!';

                    resultElement.innerHTML = `
                    <div class="text-success">
                        <p><i class="ti ti-check-circle fs-4"></i> QR code dapat diakses dan berfungsi dengan baik.</p>
                        <p>URL: ${url}</p>
                    </div>
                `;
                })
                .catch((error) => {
                    // Error response
                    statusElement.className = 'alert alert-danger';
                    statusElement.innerHTML = '<i class="ti ti-alert-circle me-1"></i> QR code tidak dapat diakses!';

                    resultElement.innerHTML = `
                    <div class="text-danger">
                        <p><i class="ti ti-alert-triangle fs-4"></i> QR code tidak dapat diakses.</p>
                        <p>Error: ${error.message}</p>
                        <p>URL: ${url}</p>
                        <p>Pastikan server Anda dapat diakses dari jaringan eksternal.</p>
                    </div>
                `;
                });
        }
    </script>
@endsection
