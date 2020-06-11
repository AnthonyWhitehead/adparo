const initialState = {
  access_token: null,
  token_type: null,
  expires_at: null,
};

const user = (state = initialState, action) => {
  switch (action.type) {
    case 'SET_USER':
      return state;
    default:
      return state;
  }
};

export default user;
