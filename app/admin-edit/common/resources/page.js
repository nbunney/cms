'use strict';

/**
 * Page resource
 */

module.exports = function (Restangular, API_ROOT) {
  var Page = Restangular.all('pages');

  Restangular.extendCollection('pages', function(collection) {
    if(!('one' in collection))
      return collection;

    collection.addRestangularMethod('create', 'post');

    return collection;
  });


  return Page;
}