@extends('layouts.app', ['title' => 'Detail Aset'])

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title fw-semibold mb-0">Detail Aset: {{ $asset->name }}</h5>
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
                                        @if ($asset->image)
                                            <img src="{{ asset('storage/' . $asset->image) }}" alt="{{ $asset->name }}"
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
                                        <b>{{ $asset->asset_number }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama Aset</th>
                                    <td>{{ $asset->name }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kategori</th>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary rounded-3 fw-semibold fs-2">
                                            {{ $asset->category->name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Deskripsi</th>
                                    <td>{{ $asset->description ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jumlah</th>
                                    <td>{{ $asset->quantity }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kondisi</th>
                                    <td>
                                        <span
                                            class="badge {{ $asset->status_color }} rounded-3 fw-semibold fs-2 text-capitalize">
                                            {{ $asset->condition }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Lokasi</th>
                                    <td>{{ $asset->location ? $asset->location->name : $asset->location ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Informasi Tambahan</th>
                                    <td>{{ $asset->additional_info ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Penanggung Jawab</th>
                                    <td>{{ $asset->location ? $asset->location->responsible_name : $asset->location ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Telepon Penanggung Jawab</th>
                                    <td>{{ $asset->location ? $asset->location->responsible_phone : $asset->location ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dibuat Pada</th>
                                    <td>{{ $asset->created_at->format('d F Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Diperbarui Pada</th>
                                    <td>{{ $asset->updated_at->format('d F Y, H:i') }}</td>
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

                <!-- QR Testing Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h5 class="card-title mb-0 text-white">QR Code Testing</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">URL QR Code:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="qrUrl"
                                                    value="{{ $asset->qr_code }}" readonly>
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
                                            <a href="{{ $asset->qr_code }}" target="_blank" class="btn btn-outline-dark">
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
                text: "{{ $asset->qr_code }}",
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

                const assetNumber = "{{ $asset->asset_number }}";

                // Create the URL for the print page
                const printUrl = `/dashboard/assets/${assetNumber}/print-qr`;

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
                    const formatNameSlug = "{{ $asset->name }}".toLowerCase().replace(/ /g, '-').replace(
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
