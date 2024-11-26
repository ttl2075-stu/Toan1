const toggle = document.getElementById('toggle');
const close = document.getElementById('close');
const open = document.getElementById('open');
const modal = document.getElementById('modal');
const navbar = document.getElementById('navbar');

// This function closes navbar if user clicks anywhere outside of navbar once it's opened
// Does not leave unused event listeners on
// It's messy, but it works
function closeNavbar(e) {
  if (
    document.body.classList.contains('show-nav') &&
    e.target !== toggle &&
    !toggle.contains(e.target) &&
    e.target !== navbar &&
    !navbar.contains(e.target)
  ) {
    document.body.classList.toggle('show-nav');
    document.body.removeEventListener('click', closeNavbar);
  } else if (!document.body.classList.contains('show-nav')) {
    document.body.removeEventListener('click', closeNavbar);
  }
}


toggle.addEventListener('click', () => {
  const isNavOpen = document.body.classList.toggle('show-nav');
  if (isNavOpen) {
    localStorage.setItem('Baihoc', 'a');
  } else {
    localStorage.setItem('Baihoc', 'b');
  }
});
// Show modal
open.addEventListener('click', () => modal.classList.add('show-modal'));

// Hide modal
close.addEventListener('click', () => modal.classList.remove('show-modal'));

// Hide modal on outside click
window.addEventListener('click', e =>
  e.target == modal ? modal.classList.remove('show-modal') : false
);


function toggleSubMenu(link) {
  let submenu = link.nextElementSibling;
  let ds = link.closest('li');
  if (submenu && submenu.tagName.toLowerCase() === 'ul') {
    if (submenu.style.display == 'block') {
      hideSubMenu(submenu);
    } else {
      showSubMenu(submenu);
      document.querySelectorAll('nav li').forEach(u => {
        u.classList.remove('open-submenu')
      })
      ds.classList.add('open-submenu');
    }
  } else {
    if (document.querySelector('.open-submenu')) {
      document.querySelectorAll('.open-submenu').forEach(element => {
        element.classList.remove('open-submenu');
      });
    }
    ds.classList.add('open-submenu')
  }
}

function hideSubMenu(submenu) {
  submenu.style.display = 'none';
  submenu.querySelectorAll('ul').forEach(element => {
    hideSubMenu(element);
  });
  let ds2 = submenu.parentElement;
  ds2.classList.remove('open-submenu');
}

function showSubMenu(submenu) {
  submenu.style.display = 'block';
}

document.querySelectorAll('nav > ul > li').forEach(u => {
  u.addEventListener('click', event => {
    if (document.querySelector('.open-submenu')) {
      document.querySelectorAll('.open-submenu').forEach(element => {
        element.classList.remove('open-submenu');
      });
    }
    event.target.classList.add('open-submenu')
  })
})

function scrollToPosition(position) {
  window.scrollTo({
    top: position,
    behavior: 'smooth' // Cuộn mượt
  });
}

// $(document).ready(function () {
//   var menu = $('#navbar');
//   var iframe = $('#content');

//   // Lắng nghe sự kiện click trên thẻ iframe
//   iframe.on('click', function (event) {
//     // Kiểm tra xem sự kiện click có xuất phát từ iframe hay không
//     if (event.target.tagName.toLowerCase() === 'iframe') {
//       // Nếu click xuất phát từ iframe, đóng menu
//       menu.removeClass('open');
//     }
//   });
// });