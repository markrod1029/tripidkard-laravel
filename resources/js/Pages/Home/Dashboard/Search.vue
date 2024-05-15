<template>
    <div class="container">
      <div class="search-top text-center mb-5 mt-5">
        <h2 class="font-weight-bold" style="font-size: 40px;">Where Do you Want To Go?</h2>
        <p class="search-top__subtitle" style="font-size:18px;">Search for their Best Offer</p>
      </div>

      <form  class="search-form row justify-content-center">
        <div class="col-md-4 mb-3">
          <div class="form-group">
            <div class="directorist-input-box">
              <input type="text"  class="form-control category-select py-4"
                placeholder="Select Category">
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="form-group">
            <div class="directorist-input-box">
              <input type="text"  class="form-control location-select py-4"
                placeholder="Select Location">
            </div>
          </div>
        </div>
        <div class="col-md-1 mb-3 d-flex justify-content-center align-items-center">
          <div class="form-group">
            <button type="submit" class="btn btn-lg btn-dark btn-search ">
              <i class="icon-search"></i> Search
            </button>
          </div>
        </div>
      </form>

    </div>
  </template>
