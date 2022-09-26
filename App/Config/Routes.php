<?php
use System\Libs\Router\Router as Route;
Route::set404(function(){
	header('HTTP/1.1 404 Not Found');
	View::render('errors.404');
});


//BACKEND
Route::Prefix('saruhanweb')->namespace('backend')->middleware(['auth', 'Localize:admin'])->group(function(){    
    //get
    Route::get('/', 'Dashboard@index');
    Route::get('/saruhanweb', 'Dashboard@index');
    Route::get('/typography', 'Typography@index');
    Route::get('/page', 'Page@index');
    Route::get('/add-page', 'Page@add');
    Route::get('/edit-page/{$ID}', 'Page@editPage')->name('page.edit');
    Route::get('/page-category', 'Page@addPageCategory');
    Route::get('/edit-page-category/{$ID}', 'Page@editPageCategory');
    Route::get('/gallery', 'Gallery@addGallery');
    Route::get('/edit-gallery/{$ID}', 'Gallery@editGallery')->name('gallery.editgallery');
    Route::get('/gallery-category', 'Gallery@galleryCategory');
    Route::get('/edit-gallery-category/{$ID}', 'Gallery@editGalleryCategory')->name('gallery.editgallerycategory');
    Route::get('/video-gallery', 'Gallery@videoGallery');
    Route::get('/edit-video/{$ID}', 'Gallery@editVideo')->name('gallery.editvideo');
    Route::get('/contact', 'Contact@index');
    Route::get('/options', 'Options@index');
    Route::get('/users', 'Users@index');
    Route::get('/user-statistic', 'Users@userStatistic');
    Route::get('/languages', 'Languages@index');
    Route::get('/edit-language/{$ID}', 'Languages@edit');
    Route::get('/logout', 'Login@logout');
    Route::get('/add-user', 'Users@add')->name('user.add');
    Route::get('/edit-user/{$ID}', 'Users@edit')->name('user.edit');
    // post
    Route::post('/add-page', 'Page@add');
    Route::post('/edit-page/{$ID}', 'Page@editPage')->name('page.edit');
    Route::post('/delete-page', 'Page@delete')->name('page.delete');
    Route::post('/add-page-category', 'Page@addPageCategory');
    Route::post('/edit-page-category/{$ID}', 'Page@editPageCategory');
    Route::post('/delete-page-category', 'Page@deletePageCategory');
    Route::post('/add-user', 'Users@add')->name('user.add');
    Route::post('/delete-user', 'Users@delete')->name('user.delete');
    Route::post('/edit-user/{$ID}', 'Users@edit')->name('user.edit');
    Route::post('/update-option','Options@update')->name('options.update');
    Route::post('/add-video','Gallery@addVideo')->name('gallery.addvideo');
    Route::post('/edit-video/{$ID}','Gallery@editVideo')->name('gallery.editvideo');
    Route::post('/delete-video','Gallery@deleteVideo')->name('gallery.deletevideo');
    Route::post('/add-gallery', 'Gallery@addGallery')->name('gallery.addgallery');
    Route::post('/edit-gallery/{$ID}', 'Gallery@editGallery')->name('gallery.editgallery');
    Route::post('/add-gallery-category', 'Gallery@addGalleryCategory')->name('gallery.addgallerycategory');
    Route::post('/edit-gallery-category/{$ID}', 'Gallery@editGalleryCategory')->name('gallery.editgallerycategory');
    Route::post('/delete-gallery-category', 'Gallery@deleteGalleryCategory')->name('gallery.deletegallerycategory');
    Route::post('/add-logo', 'Options@addLogo')->name('options.addlogo');
    Route::post('/delete-logo', 'Options@deleteLogo')->name('options.deletelogo');
    Route::post('/add-favicon', 'Options@addFavicon')->name('options.addfavicon');
    // Route::post('/delete-favicon', 'Options@deleteFavicon')->name('options.deletefavicon');
    Route::post('/add-language', 'Languages@add');
    Route::post('/edit-language/{$ID}', 'Languages@edit');
    Route::post('/delete-language', 'Languages@delete');
    Route::post('/set-site-lang', 'Languages@setSiteLang');
    Route::post('/set-admin-lang', 'Languages@setAdminLang');
    Route::get('/set-admin-lang/{lang}', 'Dashboard@set_admin_lang');
    Route::get('/logout', 'Login@logout');
});

Route::namespace('backend')->group(function(){
    Route::get('/login', 'Login@index');
    Route::post('/login', 'Login@login')->name('login.login');
});

//FRONTEND - tempalateone
Route::namespace('frontend')->middleware(['Localize:user'])->group(function () {

    $link = lang('test_lang', 'link', '', 'user');
    Route::get("/$link", 'Home@test_about'); 

    Route::get('/', 'Home@index');
    Route::get('/index',  'Home@index');
    Route::get('/iletisim', 'Contact@index');
    //Route::get('/{num}', 'Page@index');
    //
    $link_test = lang('test_lang', 'link_test', '', 'user');
    Route::get("/$link_test", 'Home@test_user_lang');
    Route::get('set-user-lang/{lang}/{ref}', 'Home@set_user_lang');
});

