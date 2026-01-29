    <!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>إتصل بنا</h2>
        <p>نحن نرحب بكل استفساراتك واقتراحاتك. لا تتردد في الاتصال بنا لأي استفسار أو مساعدة تحتاجها. يمكنك التواصل مع فريق خدمة العملاء لدينا عبر البريد الإلكتروني أو الهاتف خلال ساعات العمل، أو استخدام النموذج أدناه للحصول على دعم فوري. نحن هنا لمساعدتك في تحقيق أهدافك التجارية وضمان رضاك التام.</p>
      </div>

      <div class="row">

        <div class="col-lg-5 d-flex align-items-stretch">
          <div class="info">
            <div class="address">
              <i class="bi bi-geo-alt"></i>
              <h4>العنوان:</h4>
              <p>A108 Adam Street, New York, NY 535022</p>
            </div>

            <div class="email">
              <i class="bi bi-envelope"></i>
              <h4>البريد الإلكتروني:</h4>
              <p>info@example.com</p>
            </div>

            <div class="phone">
              <i class="bi bi-phone"></i>
              <h4>رقم الهاتف:</h4>
              <p>+1 5589 55488 55s</p>
            </div>

            {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe> --}}
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d102286.38396938733!2d3.0541521472319664!3d36.75978277379741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128fad6795639515%3A0x4ba4b4c9d0a7e602!2sAlgiers!5e0!3m2!1sen!2sdz!4v1719439133741!5m2!1sen!2sdz" width=100% height=290px style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>

        </div>

        <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
          <form action="forms/contact.php" method="post" role="form" class="php-email-form">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="name">اسمك</label>
                <input type="text" name="name" class="form-control" id="name" required>
              </div>
              <div class="form-group col-md-6">
                <label for="name">بريدك الإلكتروني</label>
                <input type="email" class="form-control" name="email" id="email" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name">الموضوع</label>
              <input type="text" class="form-control" name="subject" id="subject" required>
            </div>
            <div class="form-group">
              <label for="name">الرسالة</label>
              <textarea class="form-control" name="message" rows="10" required></textarea>
            </div>
            <div class="my-3">
              <div class="loading">تحميل</div>
              <div class="error-message"></div>
              <div class="sent-message">تم ارسال رسالتك. شكرًا لك!</div>
            </div>
            <div class="text-center"><button type="submit">أرسل رسالة</button></div>
          </form>
        </div>

      </div>

    </div>
  </section><!-- End Contact Section -->