$(function() {
	"use strict";

	const THEME_KEY = 'theme-mode';
	const CUSTOMIZER_KEY = 'customizer-theme';
	const HEADER_KEY = 'header-theme';
	const SIDEBAR_KEY = 'sidebar-theme';

	function setThemeClass(mode) {
		$('html').removeClass('light-theme dark-theme semi-dark minimal-theme').addClass(mode);
		$('.dark-mode-icon i').removeClass('bx-sun bx-moon').addClass(mode === 'dark-theme' ? 'bx-sun' : 'bx-moon');
		localStorage.setItem(THEME_KEY, mode);
	}

	function applyTheme(mode) {
		const isDark = mode === 'dark';
		$('html').removeClass('light-theme dark-theme').addClass(isDark ? 'dark-theme' : 'light-theme');
		$('.dark-mode-icon i').removeClass('bx-sun bx-moon').addClass(isDark ? 'bx-sun' : 'bx-moon');
		localStorage.setItem(THEME_KEY, mode);
	}

	function initTheme() {
		const savedMode = localStorage.getItem(THEME_KEY);
		if (savedMode === 'dark' || savedMode === 'light') {
			applyTheme(savedMode);
			return;
		}

		const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
		applyTheme(prefersDark ? 'dark' : 'light');
	}

	function applyCustomizerTheme(theme) {
		$('html').removeClass('semi-dark minimal-theme light-theme dark-theme');
		if (theme === 'light') {
			$('html').addClass('light-theme');
		} else if (theme === 'dark') {
			$('html').addClass('dark-theme');
		} else if (theme === 'semi') {
			$('html').addClass('semi-dark');
		} else if (theme === 'minimal') {
			$('html').addClass('minimal-theme');
		}
		$('#lightmode, #darkmode, #semidark, #minimaltheme').prop('checked', false);
		if (theme === 'light') $('#lightmode').prop('checked', true);
		if (theme === 'dark') $('#darkmode').prop('checked', true);
		if (theme === 'semi') $('#semidark').prop('checked', true);
		if (theme === 'minimal') $('#minimaltheme').prop('checked', true);
		localStorage.setItem(CUSTOMIZER_KEY, theme);
	}

	function applyHeaderTheme(headerClass) {
		$('html').removeClass('color-header headercolor1 headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8');
		if (headerClass) {
			$('html').addClass('color-header');
			$('html').addClass(headerClass);
		}
		localStorage.setItem(HEADER_KEY, headerClass || '');
	}

	function applySidebarTheme(sidebarClass) {
		$('html').removeClass('color-sidebar sidebarcolor1 sidebarcolor2 sidebarcolor3 sidebarcolor4 sidebarcolor5 sidebarcolor6 sidebarcolor7 sidebarcolor8');
		if (sidebarClass) {
			$('html').addClass('color-sidebar');
			$('html').addClass(sidebarClass);
		}
		localStorage.setItem(SIDEBAR_KEY, sidebarClass || '');
	}

	function resetCustomizerTheme() {
		$('html').removeClass('color-header color-sidebar light-theme dark-theme semi-dark minimal-theme headercolor1 headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8 sidebarcolor1 sidebarcolor2 sidebarcolor3 sidebarcolor4 sidebarcolor5 sidebarcolor6 sidebarcolor7 sidebarcolor8');
		$('#lightmode, #darkmode, #semidark, #minimaltheme').prop('checked', false);
		$('#lightmode').prop('checked', true);
		$('html').addClass('light-theme');
		localStorage.removeItem(CUSTOMIZER_KEY);
		localStorage.removeItem(HEADER_KEY);
		localStorage.removeItem(SIDEBAR_KEY);
	}

	function initCustomizerTheme() {
		const savedCustomizer = localStorage.getItem(CUSTOMIZER_KEY) || 'light';
		applyCustomizerTheme(savedCustomizer);

		const savedHeader = localStorage.getItem(HEADER_KEY) || '';
		applyHeaderTheme(savedHeader);

		const savedSidebar = localStorage.getItem(SIDEBAR_KEY) || '';
		applySidebarTheme(savedSidebar);
	}

	function updateDarkModeIcon() {
		const currentMode = localStorage.getItem(THEME_KEY) || 'light';
		const isDark = currentMode === 'dark';
		const $icon = $('.dark-mode-icon i');
		if ($icon.length) {
			$icon.removeClass('bx-sun bx-moon').addClass(isDark ? 'bx-sun' : 'bx-moon');
		}
	}

	initTheme();
	updateDarkModeIcon();
	initCustomizerTheme();

	// Initialize shop details in sidebar
	function initShopDetails() {
		axios.get('/shop-details')
			.then(response => {
				if (response.data) {
					const shop = response.data;
					
					// Update logo text
					if (shop.logo_text) {
						$('#logoText').text(shop.logo_text);
					}
					
					// Update logo image
					if (shop.logo) {
						const logoUrl = '/storage/' + shop.logo;
						$('#siteLogo').attr('src', logoUrl);
					}
				}
			})
			.catch(error => {
				console.log('Shop details not available');
			});
	}

	// Initialize shop details on page load
	$(document).ready(function() {
		initShopDetails();
	});

	    $(".mobile-search-icon").on("click", function() {
			$(".search-bar").addClass("full-search-bar")
		}),

		$(".search-close").on("click", function() {
			$(".search-bar").removeClass("full-search-bar")
		}),

		$(".mobile-toggle-menu").on("click", function() {
			$(".wrapper").addClass("toggled")
		}),
		



		$(".dark-mode-icon").on("click", function(e) {
			e.preventDefault();
			const currentMode = localStorage.getItem(THEME_KEY) === 'dark' ? 'light' : 'dark';
			applyTheme(currentMode);
			updateDarkModeIcon();
		}), 

		
		$(".toggle-icon").click(function() {
			$(".wrapper").hasClass("toggled") ? ($(".wrapper").removeClass("toggled"), $(".sidebar-wrapper").unbind("hover")) : ($(".wrapper").addClass("toggled"), $(".sidebar-wrapper").hover(function() {
				$(".wrapper").addClass("sidebar-hovered")
			}, function() {
				$(".wrapper").removeClass("sidebar-hovered")
			}))
		}),
		$(document).ready(function() {
			$(window).on("scroll", function() {
				$(this).scrollTop() > 300 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
			}), $(".back-to-top").on("click", function() {
				return $("html, body").animate({
					scrollTop: 0
				}, 600), !1
			})
		}),
		
		$(function() {
			for (var e = window.location, o = $(".metismenu li a").filter(function() {
					return this.href == e
				}).addClass("").parent().addClass("mm-active"); o.is("li");) o = o.parent("").addClass("mm-show").parent("").addClass("mm-active")
		}),
		
		
		$(function() {
			$("#menu").metisMenu()
		}), 
		
		$(".chat-toggle-btn").on("click", function() {
			$(".chat-wrapper").toggleClass("chat-toggled")
		}), $(".chat-toggle-btn-mobile").on("click", function() {
			$(".chat-wrapper").removeClass("chat-toggled")
		}),


		$(".email-toggle-btn").on("click", function() {
			$(".email-wrapper").toggleClass("email-toggled")
		}), $(".email-toggle-btn-mobile").on("click", function() {
			$(".email-wrapper").removeClass("email-toggled")
		}), $(".compose-mail-btn").on("click", function() {
			$(".compose-mail-popup").show()
		}), $(".compose-mail-close").on("click", function() {
			$(".compose-mail-popup").hide()
		}), 
		
		
		$(".switcher-btn").on("click", function() {
			$(".switcher-wrapper").toggleClass("switcher-toggled")
		}), $(".close-switcher").on("click", function() {
			$(".switcher-wrapper").removeClass("switcher-toggled")
		}), $("#lightmode").on("click", function() {
			applyCustomizerTheme('light');
		}), $("#darkmode").on("click", function() {
			applyCustomizerTheme('dark');
		}), $("#semidark").on("click", function() {
			applyCustomizerTheme('semi');
		}), $("#minimaltheme").on("click", function() {
			applyCustomizerTheme('minimal');
		}), $("#reset-customizer").on("click", function() {
			resetCustomizerTheme();
		}), $("#headercolor1").on("click", function() {
			applyHeaderTheme('headercolor1');
		}), $("#headercolor2").on("click", function() {
			applyHeaderTheme('headercolor2');
		}), $("#headercolor3").on("click", function() {
			applyHeaderTheme('headercolor3');
		}), $("#headercolor4").on("click", function() {
			applyHeaderTheme('headercolor4');
		}), $("#headercolor5").on("click", function() {
			applyHeaderTheme('headercolor5');
		}), $("#headercolor6").on("click", function() {
			applyHeaderTheme('headercolor6');
		}), $("#headercolor7").on("click", function() {
			applyHeaderTheme('headercolor7');
		}), $("#headercolor8").on("click", function() {
			applyHeaderTheme('headercolor8');
		})
		
	// sidebar colors 
	$('#sidebarcolor1').click(function(){ applySidebarTheme('sidebarcolor1'); });
	$('#sidebarcolor2').click(function(){ applySidebarTheme('sidebarcolor2'); });
	$('#sidebarcolor3').click(function(){ applySidebarTheme('sidebarcolor3'); });
	$('#sidebarcolor4').click(function(){ applySidebarTheme('sidebarcolor4'); });
	$('#sidebarcolor5').click(function(){ applySidebarTheme('sidebarcolor5'); });
	$('#sidebarcolor6').click(function(){ applySidebarTheme('sidebarcolor6'); });
	$('#sidebarcolor7').click(function(){ applySidebarTheme('sidebarcolor7'); });
	$('#sidebarcolor8').click(function(){ applySidebarTheme('sidebarcolor8'); });
	
	
});