{{-- <script>
function addToCartAnimation(button) {
  // منع رسوميات متعددة إذا تم النقر على الزر بسرعة
  if (button.classList.contains('animating')) return;
  button.classList.add('animating');
  
  // إنشاء عنصر الطيران
  const flyingItem = document.createElement('div');
  flyingItem.className = 'flying-item';
  
  // الحصول على صورة المنتج (تعديل المسار حسب هيكل موقعك)
  const productCard = button.closest('.product-card') || button.closest('.card') || button.closest('.product-item');
  const productImg = productCard ? productCard.querySelector('img') : null;
  
  if (productImg) {
    const imgClone = productImg.cloneNode();
    imgClone.style.width = '50px';
    imgClone.style.height = '50px';
    imgClone.style.objectFit = 'contain';
    flyingItem.appendChild(imgClone);
  } else {
    flyingItem.innerHTML = '✔';
    flyingItem.style.backgroundColor = '#4CAF50';
    flyingItem.style.color = 'white';
    flyingItem.style.fontSize = '20px';
    flyingItem.style.display = 'flex';
    flyingItem.style.alignItems = 'center';
    flyingItem.style.justifyContent = 'center';
  }
  
  // تنسيق عنصر الطيران
  Object.assign(flyingItem.style, {
    position: 'fixed',
    zIndex: '9999',
    borderRadius: '50%',
    pointerEvents: 'none',
    width: '50px',
    height: '50px',
    transition: 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)',
    left: `${button.getBoundingClientRect().left + button.offsetWidth / 2 - 25}px`,
    top: `${button.getBoundingClientRect().top}px`,
    transform: 'translateY(0) scale(1)',
    opacity: '1',
    boxShadow: '0 2px 10px rgba(0,0,0,0.2)'
  });
  
  document.body.appendChild(flyingItem);
  
  // الحصول على موقع السلة (تعديل حسب موقعك)
  const cartIcon = document.querySelector('.cart-icon') || 
                   document.querySelector('.shopping-cart') || 
                   document.querySelector('.fa-cart-shopping') ||
                   {getBoundingClientRect: () => ({left: window.innerWidth - 50, top: 20, width: 30})};
  
  const cartPos = cartIcon.getBoundingClientRect();

    // // أضف هذا داخل الدالة قبل setTimeout
    // const addSound = new Audio("{{asset('asset/v1/users/dashboard').'/sound/cash-register-kaching-sound-effect.mp3'}}");
    // addSound.volume = 0.3;
    // addSound.play().catch(e => console.log('لا يمكن تشغيل الصوت'));

  // تحريك العنصر
  setTimeout(() => {
    Object.assign(flyingItem.style, {
      left: `${cartPos.left + cartPos.width / 2 - 25}px`,
      top: `${cartPos.top}px`,
      transform: 'translateY(0) scale(0.5)',
      opacity: '0.8'
    });
  }, 10);
  
  // التنظيف بعد انتهاء الرسوميات
  setTimeout(() => {
    flyingItem.remove();
    button.classList.remove('animating');
    
    // تأثير ارتداد لأيقونة السلة
    if (cartIcon) {
      cartIcon.style.transition = 'transform 0.3s ease';
      cartIcon.style.transform = 'scale(1.3)';
      setTimeout(() => {
        cartIcon.style.transform = 'scale(1)';
      }, 300);
    }
  }, 600);
}
</script> --}}