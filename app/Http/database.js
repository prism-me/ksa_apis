User:{
    id
    name
    email
    password
    is_social
    activation_key
    deleted_at
}

uploads :{

    id
    name
    avatar
    alt
    type
    deleted_at
}
categories :{

    id
    name
    parent_id
    type
    short_description
    long_description
    featured_img
    banner_img_list
    images_list
}


products:{
    id
    code 
    category_id
    name
    description
    featured_img
    banner_img_list
    images_list
    overview:{}
    features:{}
    specifications:{}
    download
    type
    status
}

Reviews :{
    id
    user_id
    product_id
    rating
    comment
    status

}

