<template>

    <div class="container">

        <div class="search-top text-center mb-5 mt-5">
            <h2 class="font-weight-bold">Where Do you Want To Go?</h2>
            <p class="search-top__subtitle">Search for their Best Offer</p>
        </div>

        <form action="https://tripidkard.com/search-result/" class="search-form"
            data-atts="{&quot;show_title_subtitle&quot;:&quot;yes&quot;,&quot;search_bar_title&quot;:&quot;Where Do you Want To Go?&quot;,&quot;search_bar_sub_title&quot;:&quot;Search for their Best Offer&quot;,&quot;search_button&quot;:&quot;yes&quot;,&quot;search_button_text&quot;:&quot;Search&quot;,&quot;more_filters_button&quot;:&quot;&quot;,&quot;more_filters_text&quot;:&quot;&quot;,&quot;reset_filters_button&quot;:&quot;&quot;,&quot;apply_filters_button&quot;:&quot;&quot;,&quot;reset_filters_text&quot;:&quot;&quot;,&quot;apply_filters_text&quot;:&quot;&quot;,&quot;logged_in_user_only&quot;:&quot;no&quot;,&quot;redirect_page_url&quot;:&quot;&quot;,&quot;more_filters_display&quot;:&quot;overlapping&quot;,&quot;directory_type&quot;:&quot;&quot;,&quot;default_directory_type&quot;:&quot;&quot;,&quot;show_popular_category&quot;:&quot;&quot;}">

            <div class="search-form-wrap with-search-border">

                <div class="search-form-box-wrap">

                    <div class="search-form-box">

                        <div class="search-form-top row align-items-center justify-content-center">

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <div class="directorist-input-box">
                                        <input type="text" name="in_cat" class="form-control category-select"
                                            placeholder="Select Category">
                                        <i class="fa fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <div class="directorist-input-box">
                                        <input type="text" name="in_loc" class="form-control location-select"
                                            placeholder="Select Location">
                                        <i class="fa fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-dark btn-search btn-block">
                                        <i class="icon-search"></i> Search
                                    </button>
                                </div>
                            </div>



                        </div>

                    </div>
                </div>

            </div>

        </form>

    </div>


</template>


<style scoped>
.directorist-input-box {
    position: relative;
}

.directorist-input-box input {
    padding-right: 30px;
    /* Adjust the padding as needed */
}

.directorist-input-box i {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
}
</style>
