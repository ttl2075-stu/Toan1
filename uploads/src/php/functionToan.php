<?php
function isValidMathExpression($expression){
    // Kiểm tra xem biểu thức có chứa các ký tự không hợp lệ không
    if (!preg_match('/^[0-9+\-*/.() ]+$/', $expression)) {
        return false; // Biểu thức không hợp lệ
    }

    // Kiểm tra xem biểu thức có chứa các phép tính không hợp lệ không
    if (!preg_match('/[0-9]/', $expression)) {
        return false; // Biểu thức không chứa số
    }

    // Kiểm tra xem biểu thức có chứa dấu ngoặc không cân đối
    $openParentheses = substr_count($expression, '(');
    $closeParentheses = substr_count($expression, ')');
    if ($openParentheses !== $closeParentheses) {
        return false; // Dấu ngoặc không cân đối
    }

    // Kiểm tra xem biểu thức có chứa phép tính không hợp lệ như "++", "--", "**", "//" không
    $invalidOperations = ['++', '--', '**', '//'];
    foreach ($invalidOperations as $op) {
        if (strpos($expression, $op) !== false) {
            return false; // Có chứa phép tính không hợp lệ
        }
    }

    return true; // Biểu thức hợp lệ
}
