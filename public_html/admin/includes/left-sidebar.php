<div id="left-sidebar">

     <div id="sidebar-user">

      <p>Logged in as <a href="/admin/edit-portal" class="smooth-hover"><span><?php if(!empty($username)) echo $username; ?></span></a></p>

     </div>

     <ul>
       <li data-hover="manager"><a href="/admin/manager/list" class="smooth-hover">Manage Users</a></li>
       <li data-hover="home"><a href="/admin/cmsmodel/page-module/pageWithSlides?pkid=35&category=main" class="smooth-hover">Home</a></li>
       <li data-hover="products"><a href="/admin/cmsmodel/page-module/list?category=products" class="smooth-hover">Products</a></li>
       <li data-hover="services"><a href="/admin/cmsmodel/page-module/list?category=services" class="smooth-hover">Services</a></li>
       <li data-hover="bioinformatics"><a href="/admin/cmsmodel/page-module/list?category=bioinformatics" class="smooth-hover">Bioinformatics</a></li>
       <li data-hover="applications"><a href="/admin/cmsmodel/page-module/list?category=applications" class="smooth-hover">Applications</a></li>
       <li data-hover="publications"><a href="/admin/resources/publications/list" class="smooth-hover">Publications</a></li>
       <li data-hover="publications"><a href="/admin/resources/literatures/list" class="smooth-hover">Literatures</a></li>
       <li data-hover="technical-notes"><a href="/admin/cmsmodel/page-module/list?category=technical-notes" class="smooth-hover">Technical Notes</a></li>
       <li data-hover="vidoes"><a href="/admin/resources/videos/list" class="smooth-hover">Videos</a></li>
       <li data-hover="blogs"><a href="/admin/blogs/list" class="smooth-hover">Blogs</a></li>
       <li data-hover="events"><a href="/admin/news-events/events/list" class="smooth-hover">Events</a></li>
       <li data-hover="news"><a href="/admin/news-events/news/list" class="smooth-hover">News</a></li>
       <li data-hover="company"><a href="/admin/cmsmodel/page-module/list?category=promo" class="smooth-hover">Promotion Pages</a></li>
       <li data-hover="company"><a href="/admin/company/team/list" class="smooth-hover">Team</a></li>
       <li data-hover="testimonials"><a href="/admin/testimonials/list" class="smooth-hover">Testimonials</a></li>
       <li><a id="left-sidebar-logout" href="/admin/logout" class="global-btn smooth-hover">LOGOUT</a></li>
     </ul>
</div>
