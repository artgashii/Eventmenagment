<?php
function renderFooter() {
    echo <<<HTML
    <footer style="background-color: #ffffff; color: #fff; padding: 40px 0; text-align: center;">
        <div class="footer-container" style="max-width: 1200px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between;">
            <div class="footer-column" style="flex: 1; padding: 10px;">
                <h3 style="font-size: 1.8rem; margin-bottom: 1rem; color: #007bff;">About Eventura</h3>
                <p style="font-size: 1rem; color: #bbb;">We set out to redefine digital experiences. What started as a passion project soon evolved into a full-fledged agency, and our journey has been marked by collaborations, and challenges.</p>
            </div>
            
            <div class="footer-column" style="flex: 1; padding: 10px;">
                <h3 style="font-size: 1.8rem; margin-bottom: 1rem; color: #007bff;">Company</h3>
                <ul style="list-style-type: none; padding: 0;">
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">About Us</a></li>
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">Our Services</a></li>
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">Our Works</a></li>
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">Career</a></li>
                </ul>
            </div>
            
            <div class="footer-column" style="flex: 1; padding: 10px;">
                <h3 style="font-size: 1.8rem; margin-bottom: 1rem; color: #007bff;">Resources</h3>
                <ul style="list-style-type: none; padding: 0;">
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">Free eBooks</a></li>
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">Development Tutorial</a></li>
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">How to - Blog</a></li>
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">Youtube Playlist</a></li>
                </ul>
            </div>
            
            <div class="footer-column" style="flex: 1; padding: 10px;">
                <h3 style="font-size: 1.8rem; margin-bottom: 1rem; color: #007bff;">Others</h3>
                <ul style="list-style-type: none; padding: 0;">
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">Customer Support</a></li>
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">Delivery Details</a></li>
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">Terms & Conditions</a></li>
                    <li><a href="#" style="text-decoration: none; color: #bbb; font-size: 1rem;">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom" style="background-color: #ffffff; padding: 20px 0; text-align: center;">
            <p style="font-size: 1rem; color: #bbb;">© 2017-2024, All Rights Reserved</p>
        </div>
    </footer>
    HTML;
}
?>