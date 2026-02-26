<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Control Mobile System</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <script>
      var assetsPath = "{{ asset('assets/') }}/";
      var templateName = "frest";
      var config = { enableMenuLocalStorage: true };
    </script>
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <!-- Register -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="{{route('dashboard')}}" class="app-brand-link gap-2">
                  <img src="{{ asset('logo_vertical.png') }}" alt="Logo" style="width:50%; display:block; margin:0 auto;" />
                </a>
              </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Phone Number</label>
                  <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="0123456789" autofocus />
                </div>
                
                <!-- <div class="mb-3">
                  <label for="email" class="form-label">OTP Number</label>
                  <input type="text" class="form-control" id="otp_number" name="otp_number" placeholder="XXXXXX" required/>
                  <div class="mb-3">
                    <button type="button" class="btn btn-success btn-sm mt-2" id="send-otp-btn">Send OTP</button>
                  </div>
                </div> -->

                @if ($errors->any())
                    <div class="alert alert-danger" id="error-alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <script>
                        // Close alert after 5 seconds (5000 milliseconds)
                        setTimeout(() => {
                            const alert = document.getElementById('error-alert');
                            if (alert) {
                                alert.style.transition = "opacity 0.5s ease";
                                alert.style.opacity = "0";
                                setTimeout(() => alert.remove(), 500); // remove after fade out
                            }
                        }, 5000);
                    </script>
                @endif
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" id="send-otp-btn" type="submit">Reset Password</button>
                </div>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>

    <script>
    $(document).ready(function () {

        // Disable Reset Password button initially
        $("#reset-btn").prop("disabled", true);

        // Send OTP AJAX
        $("#send-otp-btn").click(function () {

            let contact = $("#contact_no").val();

            if(contact == ""){
                alert("Please enter phone number first.");
                return;
            }

            // Disable Send OTP button to prevent spamming
            // $("#send-otp-btn").prop("disabled", true).text("Sending...");

            $.ajax({
                url: "{{ route('forgot_password_check') }}", // create this route in web.php
                type: "POST",
                data: {
                    contact_no: contact,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    alert("OTP sent successfully!");
                },
                error: function () {
                    alert("Failed to send OTP. Try again.");
                }
            });
        });

    });
    </script>
  </body>
</html>

