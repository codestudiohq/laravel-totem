"use strict";

function SVGtoArray(svgObj) {
  var convertShapeToPath = require("./convertShapeToPath");
  var SVGArray = [];
  var node = void 0,
      subNode = void 0,
      groupNode = void 0,
      subsubNode = void 0;

  for (node in svgObj) {
    if (node === 'rect' || node === 'circle' || node === 'ellipse' || node === 'polygon' || node === 'line' || node === 'path') {
      var _iteratorNormalCompletion = true;
      var _didIteratorError = false;
      var _iteratorError = undefined;

      try {
        for (var _iterator = svgObj[node][Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
          subNode = _step.value;

          SVGArray.push(convertShapeToPath(subNode.$, node));
        }
      } catch (err) {
        _didIteratorError = true;
        _iteratorError = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }
        } finally {
          if (_didIteratorError) {
            throw _iteratorError;
          }
        }
      }
    } else if (node === 'g') {
      var _iteratorNormalCompletion2 = true;
      var _didIteratorError2 = false;
      var _iteratorError2 = undefined;

      try {
        for (var _iterator2 = svgObj[node][Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
          groupNode = _step2.value;

          for (subNode in groupNode) {
            if (node === 'rect' || node === 'circle' || node === 'ellipse' || node === 'polygon' || node === 'line' || node === 'path') {
              var _iteratorNormalCompletion3 = true;
              var _didIteratorError3 = false;
              var _iteratorError3 = undefined;

              try {
                for (var _iterator3 = groupNode[subNode][Symbol.iterator](), _step3; !(_iteratorNormalCompletion3 = (_step3 = _iterator3.next()).done); _iteratorNormalCompletion3 = true) {
                  subsubNode = _step3.value;

                  SVGArray.push(convertShapeToPath(subsubNode.$, subNode));
                }
              } catch (err) {
                _didIteratorError3 = true;
                _iteratorError3 = err;
              } finally {
                try {
                  if (!_iteratorNormalCompletion3 && _iterator3.return) {
                    _iterator3.return();
                  }
                } finally {
                  if (_didIteratorError3) {
                    throw _iteratorError3;
                  }
                }
              }
            }
          }
        }
      } catch (err) {
        _didIteratorError2 = true;
        _iteratorError2 = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion2 && _iterator2.return) {
            _iterator2.return();
          }
        } finally {
          if (_didIteratorError2) {
            throw _iteratorError2;
          }
        }
      }
    }
  }
  return SVGArray;
}

module.exports = {
  SVGtoArray: SVGtoArray
};