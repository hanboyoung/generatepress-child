/**
 * Mobile Menu Functionality
 * This script handles the mobile menu toggle functionality
 */

(function($) {
    $(document).ready(function() {
        initMobileMenu();
        
        // For debugging
        console.log('Mobile menu script loaded and ready');
    });
    
    function initMobileMenu() {
        const menuToggle = $('.menu-toggle, .mobile-menu-control-wrapper .menu-toggle');
        const mainNavigation = $('.main-navigation');
        const navMenu = $('.nav-menu, .main-nav');
        const siteNavigation = $('.site-header .site-navigation');
        
        console.log('Menu elements found:', {
            'menuToggle exists': menuToggle.length > 0,
            'mainNavigation exists': mainNavigation.length > 0,
            'navMenu exists': navMenu.length > 0,
            'siteNavigation exists': siteNavigation.length > 0
        });
        
        if (menuToggle.length) {
            // Make sure event is properly bound by removing any existing handlers
            menuToggle.off('click');
            
            menuToggle.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('Menu toggle clicked');
                
                menuToggle.toggleClass('toggled');
                mainNavigation.toggleClass('toggled');
                navMenu.toggleClass('toggled');
                
                if (siteNavigation.length) {
                    siteNavigation.toggleClass('toggled');
                }
                
                // Toggle ARIA attributes
                const expanded = menuToggle.attr('aria-expanded') === 'true' || false;
                menuToggle.attr('aria-expanded', !expanded);
                
                // Force visibility of the navigation
                if (!expanded) {
                    navMenu.css('display', 'block');
                    if (mainNavigation.css('display') !== 'block') {
                        mainNavigation.css('display', 'block');
                    }
                } else {
                    // Wait a bit before hiding to allow animations
                    setTimeout(function() {
                        navMenu.css('display', '');
                        mainNavigation.css('display', '');
                    }, 300);
                }
                
                console.log('Menu toggle state after click:', {
                    'menuToggle has toggled class': menuToggle.hasClass('toggled'),
                    'mainNavigation has toggled class': mainNavigation.hasClass('toggled'),
                    'navMenu has toggled class': navMenu.hasClass('toggled'),
                    'aria-expanded': !expanded
                });
                
                return false;
            });
            
            // Close menu when clicking outside
            $(document).on('click', function(event) {
                if ((navMenu.hasClass('toggled') || mainNavigation.hasClass('toggled')) && 
                    !mainNavigation.has(event.target).length && 
                    !menuToggle.has(event.target).length && 
                    !$(event.target).is(menuToggle)) {
                    
                    mainNavigation.removeClass('toggled');
                    menuToggle.removeClass('toggled');
                    navMenu.removeClass('toggled');
                    if (siteNavigation.length) {
                        siteNavigation.removeClass('toggled');
                    }
                    menuToggle.attr('aria-expanded', 'false');
                    
                    // Reset display properties
                    setTimeout(function() {
                        navMenu.css('display', '');
                        mainNavigation.css('display', '');
                    }, 300);
                    
                    console.log('Menu closed by clicking outside');
                }
            });
            
            // Close menu when window is resized above mobile breakpoint
            $(window).on('resize', function() {
                if (window.innerWidth > 768 && (navMenu.hasClass('toggled') || mainNavigation.hasClass('toggled'))) {
                    mainNavigation.removeClass('toggled');
                    menuToggle.removeClass('toggled');
                    navMenu.removeClass('toggled');
                    if (siteNavigation.length) {
                        siteNavigation.removeClass('toggled');
                    }
                    menuToggle.attr('aria-expanded', 'false');
                    
                    // Reset display properties
                    navMenu.css('display', '');
                    mainNavigation.css('display', '');
                    
                    console.log('Menu closed due to window resize');
                }
            });
            
            console.log('Mobile menu event listeners initialized');
        } else {
            console.error('Menu toggle button not found. Check your theme structure.');
        }
    }
})(jQuery); 