<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email Sudah Terverifikasi</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <style>
      body {
        background-color: #121212;
        color: #e0e0e0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .verification-card {
        background-color: #1e1e1e;
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s ease;
      }

      .verification-card:hover {
        transform: scale(1.02);
      }

      .verification-icon {
        font-size: 80px;
        margin-bottom: 20px;
      }

      .icon-warning {
        color: #ffd93d;
      }

      .btn-custom {
        background-color: #4ecdc4;
        color: #121212;
        transition: all 0.3s ease;
      }

      .btn-custom:hover {
        background-color: #45b7aa;
        color: #121212;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="card verification-card text-center p-4 mb-4">
            <div class="card-body">
              <div class="verification-icon icon-warning">
                <i class="fas fa-exclamation-circle"></i>
              </div>
              <h1 class="card-title mb-3 fs-4 text-white">
                Email Sudah Terverifikasi
              </h1>
              <p class="card-text text-white mb-4">
                Email Anda sudah pernah diverifikasi sebelumnya.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
